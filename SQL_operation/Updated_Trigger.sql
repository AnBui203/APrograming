CREATE FUNCTION dbo.Tinh_tien (@Ma_hoa_don CHAR(10))
RETURNS DECIMAL(15,3)
AS 
BEGIN
    DECLARE @Tong_tien DECIMAL(15,3);

    SET @Tong_tien = (
	SELECT COALESCE(SUM(sp.Don_gia * gs.So_luong), 0)
	FROM Gom_san_pham gs
	JOIN San_pham sp ON gs.Ma_vach = sp.Ma_vach	
	WHERE gs.So_hoa_don = @Ma_hoa_don)
	+
	(SELECT COALESCE(SUM(c.Gia * gc.So_luong), 0)
	FROM Gom_combo gc JOIN COMBO c 
	ON gc.Ma_combo = c.Ma_chuong_trinh
	WHERE gc.So_hoa_don = @Ma_hoa_don
	)
	
	DECLARE @Tien_giam DECIMAL(15,3);
	SET @Tien_giam  = 0
		SET @Tien_giam = 
		COALESCE((SELECT COALESCE((@Tong_tien * kmpt.Phan_tram_giam / 100),0)
			FROM Hoa_don hd
			JOIN Khuyen_mai_theo_phan_tram kmpt ON hd.Ma_chuong_trinh = kmpt.Ma_chuong_trinh
			JOIN  Khuyen_mai_theo_don_hang kmdh ON kmdh.Ma_chuong_trinh =hd.Ma_chuong_trinh
			WHERE hd.So_hoa_don = @Ma_hoa_don AND kmdh.Gia_toi_thieu <=	@Tong_tien
		),0);
		SET @Tien_giam =  @Tien_giam +
		COALESCE(
			(SELECT COALESCE( kmst.So_tien_giam,0)
				FROM Hoa_don hd
				JOIN Khuyen_mai_theo_so_tien kmst ON hd.Ma_chuong_trinh = kmst.Ma_chuong_trinh
				JOIN  Khuyen_mai_theo_don_hang kmdh ON kmdh.Ma_chuong_trinh =hd.Ma_chuong_trinh
				WHERE hd.So_hoa_don = @Ma_hoa_don AND kmdh.Gia_toi_thieu <=	@Tong_tien)		,0);

		SET @Tien_giam = @Tien_giam + 
		COALESCE((SELECT COALESCE(pgg.So_tien_giam,0)
			FROM Hoa_don hd
			JOIN Phieu_giam_gia pgg ON hd.Ma_giam_gia = pgg.Ma_giam_gia
			WHERE hd.So_hoa_don = @Ma_hoa_don
		),0);
		
	IF @Tien_giam > @Tong_tien
		RETURN 0
    RETURN @Tong_tien - @Tien_giam
END;

UPDATE Hoa_don
SET Tong_tien = dbo.Tinh_tien(Hoa_don.So_hoa_don)

CREATE TRIGGER Tinh_tong_tien_don_hang_san_pham
ON Gom_san_pham
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
	SET NOCOUNT ON;
		UPDATE Hoa_don
		SET Tong_tien = dbo.Tinh_tien(Hoa_don.So_hoa_don)
		WHERE Thoi_gian_xuat IS NULL
END;

CREATE TRIGGER Tinh_tong_tien_don_hang_COMBO
ON Gom_COMBO
AFTER INSERT, UPDATE, DELETE
AS
BEGIN
    SET NOCOUNT ON;
		UPDATE Hoa_don
		SET Tong_tien = dbo.Tinh_tien(Hoa_don.So_hoa_don)
		WHERE Thoi_gian_xuat IS NULL
END;
CREATE TRIGGER Tinh_tong_tien_don_hang_Hoa_don
ON Hoa_don
AFTER Update
AS
BEGIN
    SET NOCOUNT ON;
		UPDATE Hoa_don
		SET Tong_tien = dbo.Tinh_tien(Hoa_don.So_hoa_don)
		WHERE Thoi_gian_xuat IS NULL
END;


CREATE TRIGGER Tich_diem
ON Hoa_don
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
			
			DECLARE @Diem_cong DECIMAL(15,3)
				= 
				(SELECT hd.Tong_tien
				FROM Hoa_don hd
				JOIN inserted i ON i.Ma_khach_hang = hd.Ma_khach_hang AND i.So_hoa_don = hd.So_hoa_don
				JOIN deleted d ON d.Ma_khach_hang = hd.Ma_khach_hang
				WHERE i.thoi_gian_xuat IS NOT NULL AND d.thoi_gian_xuat IS NULL		
				)
			SET @Diem_cong =
				CASE 
					WHEN @Diem_cong > 1000000 THEN 200
					WHEN @Diem_cong > 500000 THEN 40
					WHEN @Diem_cong > 200000 THEN 15
					WHEN @Diem_cong > 100000 THEN 5
					ELSE 0
				END;
				
			UPDATE Thanh_vien
			SET Diem_tich_luy = Diem_tich_luy + @Diem_cong		
			FROM Thanh_vien tv
			JOIN inserted i ON i.Ma_khach_hang = tv.Ma_khach_hang
			JOIN deleted d ON d.Ma_khach_hang = tv.Ma_khach_hang
			WHERE i.thoi_gian_xuat IS NOT NULL AND d.thoi_gian_xuat IS NULL			
END;

CREATE TRIGGER Xoa_san_pham_0
ON Gom_san_pham
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;
	DELETE gs
	FROM Gom_san_pham gs
	JOIN inserted i ON i.So_hoa_don = gs.So_hoa_don AND i.Ma_vach = gs.Ma_vach
	WHERE i.So_luong = 0;
END;

CREATE TRIGGER Xoa_combo_0
ON Gom_combo
AFTER UPDATE
AS
BEGIN
	SET NOCOUNT ON;
	DELETE gcb
	FROM Gom_combo gcb
	JOIN inserted i ON i.So_hoa_don = gcb.So_hoa_don AND i.Ma_combo = gcb.Ma_combo
	WHERE i.So_luong = 0;
END;

UPDATE Hoa_don SET Thoi_gian_xuat = NULL WHERE So_hoa_don = '9999'
SELECT *
FROM dbo.Hoa_don
WHERE Thoi_gian_xuat IS NULL
SELECT *
FROM Thanh_vien
SELECT *
FROM Gom_san_pham


UPDATE Hoa_don
SET Thoi_gian_xuat = '2023-09-11'
WHERE Ma_khach_hang = 100011




UPDATE Gom_san_pham
SET So_luong=2
WHERE Ma_vach='121130' AND So_hoa_don='1128'

DROP TRIGGER Tich_diem
DROP FUNCTION Tinh_tien
DROP TRIGGER Tinh_tong_tien_don_hang_COMBO
DROP TRIGGER Tinh_tong_tien_don_hang_san_pham
