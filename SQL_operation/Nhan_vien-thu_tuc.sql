CREATE PROCEDURE Delete_nhan_vien
	@Ma_so CHAR(10)
AS
BEGIN
	IF (NOT EXISTS(SELECT * FROM Nhan_vien WHERE Nhan_vien.Ma_so = @Ma_so))
		THROW 50000, 'Ma so nhan vien khong ton tai',1;
	DELETE FROM Nhan_vien WHERE Nhan_vien.Ma_so = @Ma_so;
		
END
CREATE PROCEDURE Add_nhan_vien
    @Ma_so CHAR(10),
    @CCCD CHAR(12),
    @Dia_chi VARCHAR(30),
    @Ngay_sinh DATE,
    @Gioi_tinh CHAR(5),
    @Ho_va_ten VARCHAR(30),
    @Ma_chi_nhanh CHAR(10)
AS
BEGIN
	IF (NOT EXISTS (SELECT * FROM Chi_nhanh WHERE Chi_nhanh.Ma_chi_nhanh = @Ma_chi_nhanh))
		THROW 50000, 'Chi nhanh khong ton tai',1;
	IF (EXISTS(SELECT * FROM Nhan_vien WHERE Nhan_vien.Ma_so = @Ma_so))
		THROW 50000, 'Ma so nhan vien da ton tai',1;
	IF (EXISTS (SELECT * FROM Nhan_vien WHERE Nhan_vien.CCCD = @CCCD))
		THROW 50000, 'CCCD nhan vien da ton tai',1;
	IF NOT (LEN(@CCCD) = 12 AND @CCCD LIKE '0[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]')
		THROW 50000, 'Can cuoc cong dan khong dung dinh dang 12 chu so', 1;
	IF (@Gioi_tinh NOT IN ('Nam', 'Nu'))
		THROW 50000, 'Gioi tinh khong dung dinh danh, vui long dien Nam hoac Nu', 1
	IF NOT (@Ngay_sinh LIKE '[1-2][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]')
		THROW 50000, 'Ngay sinh khong dung dinh danh hoac nam sinh khong dung yeu cau', 1;
    -- Insert data into Nhan_vien, SDT_nhan_vien, Email_nhan_vien tables
    INSERT INTO Nhan_vien (Ma_so, CCCD, Dia_chi, Ngay_sinh, Gioi_tinh, Ho_va_ten, Ma_chi_nhanh)
    VALUES (@Ma_so, @CCCD, @Dia_chi, @Ngay_sinh, @Gioi_tinh, @Ho_va_ten, @Ma_chi_nhanh);
END;

CREATE PROCEDURE Update_nhan_vien
	@Ma_so CHAR(10),
	@Dia_chi VARCHAR(30),
	@Ngay_sinh DATE,
    @Ma_chi_nhanh CHAR(10)
AS
BEGIN
	IF (NOT EXISTS (SELECT * FROM Chi_nhanh WHERE Chi_nhanh.Ma_chi_nhanh = @Ma_chi_nhanh))
		THROW 50000, 'Chi nhanh khong ton tai',1;
	IF (NOT EXISTS(SELECT * FROM Nhan_vien WHERE Nhan_vien.Ma_so = @Ma_so))
		THROW 50000, 'Ma so nhan vien khong ton tai',1;
	IF NOT (@Ngay_sinh LIKE '[1-2][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]')
		THROW 50000, 'Ngay sinh khong dung dinh danh hoac nam sinh khong dung yeu cau', 1;
	DECLARE @CCCD char(12) =(SELECT CCCD FROM Nhan_vien WHERE Ma_so = @Ma_so)
		UPDATE Nhan_vien SET Nhan_vien.Dia_chi = @Dia_chi,
			Nhan_vien.Ngay_sinh= @Ngay_sinh,
			Nhan_vien.Ma_chi_nhanh = @Ma_chi_nhanh
			WHERE Nhan_vien.Ma_so = @Ma_so;
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

DROP PROC Add_nhan_vien; 
DROP PROC Update_nhan_vien;
EXEC Add_nhan_vien '8788','0123456789012','12 ok','2001-12-20','Nu','Ok Van A','1','0999989999','a@a.cn'