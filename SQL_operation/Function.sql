CREATE FUNCTION dbo.BestSeller(@MaChiNhanhInput CHAR(10))
RETURNS TABLE
AS
RETURN (
    SELECT TOP 100 PERCENT
        ctkm.Ma_chuong_trinh,
        ctkm.Ten_chuong_trinh,
        COUNT(hd.Ma_chuong_trinh) AS SoLanApDung
    FROM
        Chuong_trinh_khuyen_mai ctkm
    LEFT JOIN
        Hoa_don hd ON ctkm.Ma_chuong_trinh = hd.Ma_chuong_trinh
    WHERE
        ctkm.Ma_chi_nhanh = @MaChiNhanhInput
    GROUP BY
        ctkm.Ma_chuong_trinh, ctkm.Ten_chuong_trinh
    ORDER BY
        SoLanApDung DESC
);

SELECT * FROM dbo.BestSeller(1);


CREATE FUNCTION dbo.TinhLuongNhanVien(@MaSoNV CHAR(10), @Thang INT, @Nam INT)
RETURNS DECIMAL(10, 2)
AS
BEGIN
    DECLARE @Luong DECIMAL(10, 2);

    SELECT @Luong = ISNULL(SUM(DATEDIFF(HOUR, Gio_bat_dau, Gio_ket_thuc) * Luong_tren_gio), 0)
    FROM Ca_lam_viec
    JOIN Nhan_vien_ban_thoi_gian ON Ca_lam_viec.Ma_so = Nhan_vien_ban_thoi_gian.Ma_so
                                    AND Ca_lam_viec.CCCD = Nhan_vien_ban_thoi_gian.CCCD
    WHERE Ca_lam_viec.Ma_so = @MaSoNV
      AND MONTH(Ca_lam_viec.Ngay_thang_nam) = @Thang
      AND YEAR(Ca_lam_viec.Ngay_thang_nam) = @Nam;

    IF @Luong IS NULL
    BEGIN
        SELECT @Luong = ISNULL(Luong_co_dinh, 0)
        FROM Nhan_vien_van_phong
        WHERE Ma_so = @MaSoNV;

        IF @Luong IS NULL
        BEGIN
            SELECT @Luong = ISNULL(Luong_co_dinh, 0)
            FROM Nhan_vien_toan_thoi_gian
            WHERE Ma_so = @MaSoNV;
        END;
    END;

    RETURN @Luong;
END;