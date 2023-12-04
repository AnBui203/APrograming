CREATE PROCEDURE Delete_nhan_vien
	@Ma_so CHAR(10)
AS
BEGIN
	
	DELETE FROM Nhan_vien WHERE Nhan_vien.Ma_so = @Ma_so;
		
END
CREATE PROCEDURE Add_nhan_vien
    @Ma_so CHAR(10),
    @CCCD CHAR(12),
    @Dia_chi VARCHAR(30),
    @Ngay_sinh DATE,
    @Gioi_tinh CHAR(5),
    @Ho_va_ten VARCHAR(30),
    @Ma_chi_nhanh CHAR(10),
    @SDT VARCHAR(20),
    @Email VARCHAR(30)
AS
BEGIN
 
    -- Insert data into Nhan_vien, SDT_nhan_vien, Email_nhan_vien tables
    INSERT INTO Nhan_vien (Ma_so, CCCD, Dia_chi, Ngay_sinh, Gioi_tinh, Ho_va_ten, Ma_chi_nhanh)
    VALUES (@Ma_so, @CCCD, @Dia_chi, @Ngay_sinh, @Gioi_tinh, @Ho_va_ten, @Ma_chi_nhanh);

    INSERT INTO SDT_nhan_vien(Ma_so, CCCD, SDT) VALUES (@Ma_so, @CCCD, @SDT);

    INSERT INTO Email_nhan_vien(Ma_so, CCCD, Email) VALUES (@Ma_so, @CCCD, @Email);
END;

CREATE PROCEDURE Update_nhan_vien
	@Ma_so CHAR(10),
	@Dia_chi VARCHAR(30),
	@Ngay_sinh DATE,
    @Ma_chi_nhanh CHAR(10),
    @SDT VARCHAR(20),
    @Email VARCHAR(30)
AS
BEGIN
	
	DECLARE @CCCD char(12) =(SELECT CCCD FROM Nhan_vien WHERE Ma_so = @Ma_so)
		UPDATE Nhan_vien SET Nhan_vien.Dia_chi = @Dia_chi,
			Nhan_vien.Ngay_sinh= @Ngay_sinh,
			Nhan_vien.Ma_chi_nhanh = @Ma_chi_nhanh
			WHERE Nhan_vien.Ma_so = @Ma_so;
		IF NOT EXISTS (SELECT * FROM Email_nhan_vien WHERE Ma_so = @Ma_so)
			INSERT INTo Email_nhan_vien VALUES (@Ma_so, @CCCD, @Email )
		ELSE
			UPDATE Email_nhan_vien SET Email_nhan_vien.Email = @Email WHERE Email_nhan_vien.Ma_so = @Ma_so AND @Email != '';
		IF NOT EXISTS (SELECT * FROM SDT_nhan_vien WHERE Ma_so = @Ma_so)
			INSERT INTo SDT_nhan_vien VALUES (@Ma_so, @CCCD, @SDT )
		ELSE
			UPDATE SDT_nhan_vien SET SDT_nhan_vien.SDT = @SDT WHERE SDT_nhan_vien.Ma_so = @Ma_so AND @SDT != '' ;
END



CREATE PROCEDURE Hien_thi_gio_lam_viec
(
    @branch_code CHAR(10),
    @year INT,
    @month INT
)
AS
BEGIN
    DECLARE @start_date DATE, @end_date DATE;
    SET @start_date = DATEFROMPARTS(@year, @month, 1);
    SET @end_date = DATEADD(DAY, -1, DATEADD(MONTH, 1, @start_date));

    SELECT nv.Ma_so AS Ma_nhan_vien, nv.Ho_va_ten AS Ten_nhan_vien, SUM(DATEDIFF(HOUR, clv.Gio_bat_dau, clv.Gio_ket_thuc)) AS Gio_lam_viec
    FROM Nhan_vien nv
    JOIN Nhan_vien_ban_thoi_gian nvtg ON nv.Ma_so = nvtg.Ma_so AND nv.CCCD = nvtg.CCCD
    JOIN Ca_lam_viec clv ON clv.Ma_so = nvtg.Ma_so AND clv.CCCD = nvtg.CCCD
    WHERE nv.Ma_chi_nhanh = @branch_code
        AND clv.Ngay_thang_nam >= @start_date AND clv.Ngay_thang_nam <= @end_date
    GROUP BY nv.Ma_so, nv.Ho_va_ten
    ORDER BY Gio_lam_viec DESC;
END;





CREATE PROCEDURE Don_hang_theo_cn
    @branch_code CHAR(10)
AS
BEGIN
    SELECT Thanh_vien.Ma_thanh_vien, Thanh_vien.Ho_va_ten, SUM(Hoa_don.Tong_tien) AS Tong_tien_don_hang
    FROM Hoa_don
    JOIN Thanh_vien ON Hoa_don.Ma_khach_hang = Thanh_vien.Ma_khach_hang
    WHERE Hoa_don.Ma_chi_nhanh = @branch_code
    GROUP BY Thanh_vien.Ma_thanh_vien, Thanh_vien.Ho_va_ten
    ORDER BY Tong_tien_don_hang DESC;
END;

CREATE PROCEDURE dbo.Cap_nhat_hd
@Ten varchar(30),
@Ma_kh char(10),
@Ma_nv char(10),
@Ma_cn char(10),
@So_hd char(10),
@Ma_giam_gia char(10),
@Ma_ct char (10)
AS
BEGIN
	DECLARE @CCCD char(12);
	SELECT @CCCD =CCCD FROM dbo.Nhan_vien WHERE Ma_so = @Ma_nv;
	UPDATE [dbo].[Hoa_don] 
	SET Ten_hoa_don = @Ten,
		Ma_khach_hang = @Ma_kh,
		Ma_so_nhan_vien_duyet = @Ma_nv,
		CCCD_nhan_vien_duyet=@CCCD,
		Ma_chi_nhanh = @Ma_cn,
		Ma_giam_gia=@Ma_giam_gia,
		Ma_chuong_trinh=@Ma_ct
	WHERE So_hoa_don = @So_hd
END;

CREATE PROCEDURE dbo.Them_hoa_don (@So_hoa_don Char(10), @Ten Char(30), @Ma_kh char(10), @Ma_nv char(10), @Ma_cn char(10))
SET @CCCD = SELECT CCCD FROM dbo.Nhan_vien WHERE Ma_so = @Ma_nv;
INSERT INTO dbo.Hoa_don VALUES (@So_hoa_don, @Ten, NULL, @Ma_kh, NULL, NULL, @Ma_nv, @CCCD, @Ma_cn, NULL);

CREATE PROCEDURE dbo.Them_hoa_don 
    @So_hoa_don Char(10), 
    @Ten Char(30), 
    @Ma_kh char(10), 
    @Ma_nv char(10), 
    @Ma_cn char(10)
AS
BEGIN
    DECLARE @CCCD Char(10); 

    SELECT @CCCD = CCCD FROM dbo.Nhan_vien WHERE Ma_so = @Ma_nv;

    INSERT INTO dbo.Hoa_don 
    VALUES (@So_hoa_don, @Ten, NULL, @Ma_kh, NULL, NULL, @Ma_nv, @CCCD, @Ma_cn, NULL);
END;

ALTER TABLE Hoa_don ADD Tong_tien DECIMAL(10,3);

EXEC Don_hang_theo_cn '1';
DROP PROC Don_hang_theo_cn;
DROP PROC Hien_thi_gio_lam_viec;
EXEC Hien_thi_gio_lam_viec '2', 2022, 11 ;

