

----------------------------- Create Table -----------------------
CREATE TABLE Chi_nhanh 
(	
	Ma_chi_nhanh	CHAR(10)	NOT NULL PRIMARY KEY,
	Ten		VARCHAR(40),					
	Tinh_thanh	VARCHAR(30),
	Quan_huyen	VARCHAR(30),
	Thi_xa		VARCHAR(30),
	Ten_duong	VARCHAR(30),
	Email		VARCHAR(30),
	So_fax	INT,
	Ma_so_quan_ly	CHAR(10),
	CCCD_quan_ly	CHAR(12)
);

CREATE TABLE Email_chi_nhanh
(
	Ma_chi_nhanh	CHAR(10)	NOT NULL ,
	Email	VARCHAR(30) NOT NULL,
	PRIMARY KEY (Ma_chi_nhanh,Email)
);
CREATE TABLE SDT_chi_nhanh
(
	Ma_chi_nhanh	CHAR(10)	NOT NULL,
	SDT		VARCHAR(12)	NOT NULL,
	PRIMARY KEY (Ma_chi_nhanh,SDT)
);


CREATE TABLE Nha_cung_cap
(
	Ma_so	CHAR(10)	NOT NULL PRIMARY KEY,
	Ten		VARCHAR(30),
	Tinh_thanh	VARCHAR(30),
	Quan_huyen	VARCHAR(30),
	Thi_xa		VARCHAR(30),
	Ten_duong	VARCHAR(30)
);


CREATE TABLE Cung_cap
(
	Ma_vach	CHAR(10)	NOT NULL PRIMARY KEY,
	Ma_so_nha_cung_cap		CHAR(10),
	So_luong_nhap	VARCHAR(30),
	Ngay_giao_san_pham	DATE,
	Phi_giao_hang	DECIMAL(10,3)
);

CREATE TABLE Hop_tac
(
	Ma_so_nha_cung_cap		CHAR(10)	NOT NULL,
	Ma_chi_nhanh	CHAR(10)	NOT NULL,
	PRIMARY KEY(Ma_so_nha_cung_cap,Ma_chi_nhanh)
);

CREATE TABLE Doanh_thu
(
	Ma_chi_nhanh	CHAR(10)	NOT NULL ,
	Ngay_quyet_toan	DATE,
	PRIMARY KEY (Ma_chi_nhanh,Ngay_quyet_toan)
);

CREATE TABLE Khu_vuc_ngoi
(
	Ma_khu CHAR(10)	NOT NULL ,
	Ma_chi_nhanh	CHAR(10)	NOT NULL,
	Thoi_gian_mo_cua	DATE,
	Thoi_gian_dong_cua	DATE,
	PRIMARY KEY (Ma_khu,Ma_chi_nhanh)
);
-------------------------------------------------------------------
CREATE TABLE Chuong_trinh_khuyen_mai 
(	Ma_chuong_trinh		CHAR(10)	Primary Key,
	Ten_chuong_trinh		VARCHAR(30)		NOT NULL,					
	The_le		TEXT	NOT NULL,
	Thoi_gian_bat_dau		DATE	NOT NULL,
	Thoi_gian_ket_thuc		DATE	NOT NULL,
	Ma_chi_nhanh	CHAR(10)		NOT NULL
);

CREATE TABLE COMBO
(	Ma_chuong_trinh		CHAR(10)	Primary Key,
	Gia		DECIMAL(10,3)		NOT NULL
);

CREATE TABLE Khuyen_mai_theo_don_hang
(	Ma_chuong_trinh		CHAR(10)	Primary Key,
	Gia_toi_thieu		INT		NOT NULL
);

CREATE TABLE Khuyen_mai_theo_so_tien
(	Ma_chuong_trinh		CHAR(10)	Primary Key,
	So_tien_giam		DECIMAL(10,3)		NOT NULL	
);

CREATE TABLE Khuyen_mai_theo_phan_tram
(	Ma_chuong_trinh		CHAR(10)	Primary Key,
	Phan_tram_giam		INT		NOT NULL,	
	Giam_toi_da		DECIMAL(10,3)		NOT NULL
);

CREATE TABLE Bao_gom
(	Ma_vach		CHAR(10)	NOT NULL,
	Ma_chuong_trinh		CHAR(10)	NOT NULL,
	So_luong		INT		NOT NULL,	
	PRIMARY KEY (Ma_vach, Ma_chuong_trinh)
);

CREATE TABLE Gom_combo
(	So_hoa_don		CHAR(10)	NOT NULL,
	Ma_combo		CHAR(10)	NOT NULL,
	So_luong		INT		NOT NULL,	
	PRIMARY KEY (So_hoa_don, Ma_combo)
);

CREATE TABLE Gom_san_pham
(	So_hoa_don		CHAR(10)	NOT NULL,
	Ma_vach		CHAR(10)	NOT NULL,
	So_luong		INT		NOT NULL,	
	PRIMARY KEY (So_hoa_don, Ma_vach)
);
--------------------------------------------------------
CREATE TABLE Nhan_vien(
	Ma_so CHAR(10),
    CCCD CHAR(12),
    Dia_chi VARCHAR(30) NOT NULL,
    Ngay_sinh DATE NOT NULL,
    Gioi_tinh CHAR(5) NOT NULL,
    Ho_va_ten VARCHAR(30) NOT NULL,
    Ma_chi_nhanh CHAR(10) NOT NULL,
	PRIMARY KEY(Ma_so, CCCD)
);
CREATE TABLE Email_nhan_vien(
	Ma_so CHAR(10),
	CCCD CHAR(12),
    Email VARCHAR(30) NOT NULL,
	PRIMARY KEY(Ma_so,CCCD,Email)
);
CREATE TABLE SDT_nhan_vien(
	Ma_so CHAR(10),
	CCCD CHAR(12),
    SDT VARCHAR(20) NOT NULL,
	PRIMARY KEY(Ma_so,CCCD,SDT)
);
CREATE TABLE Nhan_vien_van_phong(
	Ma_so CHAR(10) ,
	CCCD CHAR(12),
	Luong_co_dinh DECIMAL(10, 3) NOT NULL,
    Vi_tri_lam_viec VARCHAR(100) NOT NULL,
	PRIMARY KEY(Ma_so,CCCD)
);
CREATE TABLE Nhan_vien_phuc_vu(
	Ma_so CHAR(10),
	CCCD CHAR(12),
    Ma_so_nhan_vien_giam_sat CHAR(10),
    CCCD_nhan_vien_giam_sat CHAR(12),
	PRIMARY KEY(Ma_so,CCCD)
);
CREATE TABLE Nhan_vien_toan_thoi_gian(
	Ma_so CHAR(10),
	CCCD CHAR(12),
    Luong_co_dinh DECIMAL(10, 2) NOT NULL,
	PRIMARY KEY(Ma_so,CCCD)
);
CREATE TABLE Nhan_vien_ban_thoi_gian(
	Ma_so CHAR(10),
	CCCD CHAR(12),
    Luong_tren_gio DECIMAL(10, 2) NOT NULL,
	PRIMARY KEY(Ma_so,CCCD)
);
CREATE TABLE Ca_lam_viec(
	Ma_so CHAR(10),
	CCCD CHAR(12),
    Ngay_thang_nam DATE NOT NULL,
    Gio_bat_dau TIME NOT NULL,
    Gio_ket_thuc TIME NOT NULL,
	PRIMARY KEY(Ma_so, CCCD, Ngay_thang_nam, Gio_bat_dau)
);
----------------------------------------------
CREATE TABLE San_pham(
	Ma_vach CHAR(10) PRIMARY KEY,
    So_luong INT,
    Don_gia DECIMAL(10,3) NOT NULL,
    Ten VARCHAR(30) NOT NULL,
    Nhan_hieu VARCHAR(30) NOT NULL,
    Nguon_goc_xuat_xu VARCHAR(30) NOT NULL,
    Nha_san_xuat VARCHAR(30) NOT NULL,
	NSX DATE,
	HSD DATE
);

CREATE TABLE Hoa_my_pham(
	Ma_vach CHAR(10) PRIMARY KEY NOT NULL,
    Phan_loai VARCHAR(30),
    Qua_cach VARCHAR(30) NOT NULL
);

CREATE TABLE Hang_hoa_khac(
	Ma_vach CHAR(10) PRIMARY KEY NOT NULL,
    Chat_lieu VARCHAR(30),
    Dinh_luong VARCHAR(30) NOT NULL,
	Kich_thuoc VARCHAR(30) NOT NULL
);

CREATE TABLE Thuc_pham(
	Ma_vach CHAR(10) PRIMARY KEY NOT NULL,
    Gia_tri_dinh_duong VARCHAR(30),
    Thanh_phan_chinh VARCHAR(50)
);

CREATE TABLE Do_an(
	Ma_vach CHAR(10) PRIMARY KEY NOT NULL,
    Khoi_luong_tinh VARCHAR(30)
);
CREATE TABLE Thuc_uong(
	Ma_vach CHAR(10) PRIMARY KEY NOT NULL,
    The_tich_thuc VARCHAR(30)
);

CREATE TABLE Hoa_don(
	So_hoa_don CHAR(10) PRIMARY KEY NOT NULL,
    Ten_hoa_don VARCHAR(30),
	Thoi_gian_xuat DATE,
	Ma_khach_hang CHAR(10) NOT NULL,
	Ma_giam_gia CHAR(10),
	Ma_chuong_trinh CHAR(10),
	Ma_so_nhan_vien_duyet CHAR(10) NOT NULL,
	CCCD_nhan_vien_duyet CHAR(12) NOT NULL,
	Ma_chi_nhanh CHAR(10) NOT NULL,
	Tong_tien DECIMAL(15,3),
);

CREATE TABLE Khach_hang(
	Ma_khach_hang CHAR(10) PRIMARY KEY NOT NULL
);
CREATE TABLE Thanh_vien(
	Ma_thanh_vien CHAR(10)  NOT NULL,
	CCCD CHAR(12) NOT NULL,
	Ho_va_ten VARCHAR(30),
    Gioi_tinh CHAR(5) NOT NULL,
	Diem_tich_luy INT,
	Ma_khach_hang CHAR(10),
	PRIMARY KEY (Ma_thanh_vien,CCCD)
);
CREATE TABLE Phieu_giam_gia(
	Ma_giam_gia CHAR(10) PRIMARY KEY NOT NULL,
	CCCD CHAR(12) NOT NULL,
	So_tien_giam DECIMAL(10,3) NOT NULL,
	Ma_thanh_vien CHAR(10)
);

-------------------------- Instert Data --------------------------


INSERT INTO Chi_nhanh 
VALUES 
(1, 'CircleK Lao Cai', 'Nam Dinh', 'Tp. Nam Dinh', 'Tran Hung Dao', 'Hai Ba Trung', 'circleklaocai17@gmail.com', 1778192, '1005', '123456789'),
(2, 'CircleK doi dien Benh vien Thong Nhat', 'TP. Ho Chi Minh', 'Tan Binh', 'Phuong 7', 'Ly Thuong Kiet', 'circlekthongnhat@gmail.com', 1821132, '2011', '123617846'),
(3, 'CircleK Nga tu Bay Hien', 'TP. Ho Chi Minh', 'Tan Binh', 'Phuong 11', 'Ly Thuong Kiet', 'circlekbayhien@gmail.com', 1912345, '3033', '123987423');

INSERT INTO Email_chi_nhanh 
VALUES 
('1', 'circleklaocai@gmail.com'),
('2', 'ckthongnhat@gmail.com'),
('3', 'circlekbayhien@gmail.com');

INSERT INTO SDT_chi_nhanh 
VALUES 
('1', '87688112'),
('2', '99123123'),
('3', '79064546');

INSERT INTO Nha_cung_cap 
VALUES 
('221', 'Co Ba Che chuoi', 'Binh Duong', 'Di An', 'Dong Hoa', 'To Vinh Dien'),
('222', 'Warehouse Thu Duc', 'Ho Chi Minh City', 'Thu Duc', 'Linh Tay', 'Hoang Hoa Tham'),
('223', 'Warehouse Mr. Ba', 'Ho Chi Minh City', 'Tan Binh', 'Ward 7', 'Ly Thuong Kiet');

INSERT INTO Cung_cap 
VALUES 
('100000', '221', '100', '2023-11-01', 80000.000),
('100123', '221', '120', '2023-11-01', 120000.000),
('111133', '221', '150', '2023-11-02', 80000.000),
('112130', '222', '50', '2023-10-30', 50000.000),
('112233', '222', '100', '2023-10-04', 30000.000),
('121130', '223', '120', '2023-11-24', 100000.000),
('121310', '222', '110', '2023-11-12', 99000.000),
('144441', '223', '300', '2023-11-08', 45000.000),
('199999', '223', '100', '2023-11-08', 62000.000),
('200003', '223', '200', '2023-11-12', 74000.000),
('211211', '222', '180', '2023-11-12', 38000.000),
('224234', '221', '189', '2023-11-04', 55000.000),
('345678', '223', '190', '2023-11-01', 88000.000);

INSERT INTO Hop_tac 
VALUES 
('221', '1'),
('222', '2'),
('223', '3');
INSERT INTO Doanh_thu 
VALUES 
('1', '2023-10-31'),
('2', '2023-10-31'),
('3', '2023-10-31');
INSERT INTO Khu_vuc_ngoi 
VALUES 
('11', '1', '2023-11-01', '2023-11-01'),
('12', '1', '2023-11-01', '2023-11-01'),
('21', '2', '2023-10-31', '2023-10-31'),
('31', '3', '2023-10-31', '2023-11-01');

-------------------------------------------------------------------------------

INSERT INTO Chuong_trinh_khuyen_mai 
(Ma_chuong_trinh, Ten_chuong_trinh, The_le, Thoi_gian_bat_dau, Thoi_gian_ket_thuc, Ma_chi_nhanh) VALUES
('101', 'giam 5000', 'giam 5000', '2023-11-06', '2023-11-23', '1'),
('102', 'giam 10 000', 'giam 10 000', '2023-11-01', '2023-11-05', '2'),
('103', 'giam 1000', 'giam 1000', '2023-11-20', '2023-11-26', '3'),
('821', 'giam 5%', 'giam 5%', '2023-11-01', '2023-11-30', '1'),
('822', 'giam 10%', 'giam 10%', '2023-10-01', '2023-10-31', '2'),
('823', 'giam 15%', 'giam 15%', '2023-12-02', '2024-01-01', '3'),
('911', 'combo chien long tai thien', 'combo chien long tai thien', '2023-11-20', '2023-11-21', '1'),
('912', 'combo bao doi bao dom', 'combo bao doi bao dom', '2023-11-23', '2023-11-26', '2'),
('913', 'combo chua te hac am', 'combo chua te hac am', '2023-11-20', '2023-12-03', '3');

-- COMBO
INSERT INTO COMBO 
(Ma_chuong_trinh, Gia) VALUES
('911', 20000),
('912', 36000),
('913', 130000);

-- Khuyen_mai_theo_don_hang
INSERT INTO Khuyen_mai_theo_don_hang 
(Ma_chuong_trinh, Gia_toi_thieu) VALUES
('101', 5000),
('102', 10000),
('103', 1000),
('821', 10000),
('822', 100000),
('823', 50000),
('911', 0),
('912', 0),
('913', 0);

-- Khuyen_mai_theo_so_tien
INSERT INTO Khuyen_mai_theo_so_tien (Ma_chuong_trinh, So_tien_giam) VALUES
('101', 5000),
('102', 10000),
('103', 1000);

-- Khuyen_mai_theo_phan_tram
INSERT INTO Khuyen_mai_theo_phan_tram VALUES
('821', 5, 20000),
('822', 10, 50000),
('823', 15, 75000);

-- Bao_gom
INSERT INTO Bao_gom (Ma_vach, Ma_chuong_trinh, So_luong)
VALUES ('111133', '911', 1),
('224234', '911', 1),
('121310', '912', 3),
('200003', '913', 1),
('121310', '913', 1);

-- Gom_combo
INSERT INTO Gom_combo (So_hoa_don, Ma_combo, So_luong) VALUES
('1122', '911', 2),
('2234', '912', 1),
('3235', '913', 1);

-- Gom_san_pham
INSERT INTO Gom_san_pham (So_hoa_don, Ma_vach, So_luong) VALUES
('1122', '112130', 1),
('1122', '121310', 4),
('1211', '345678', 1),
('1233', '200003', 5),
('2234', '211211', 10),
('2344', '100000', 2),
('3235', '121130', 3),
('3443', '199999', 1),
('2234', '144441', 1),
('3235', '100123', 6);

-- Nhan_vien
INSERT INTO Nhan_vien VALUES
('1001', '177123130', 'Ha Tay', '2001-02-12', 'Nam', 'William Hung', '1'),
('1002', '133234444', 'Tay Ninh', '2000-02-09', 'Nam', 'John Cena', '1'),
('1003', '134545677', 'Quang Nam', '2004-02-29', 'Nu', 'Thuy Pham', '1'),
('1004', '177777771', 'TT Hue', '2002-12-12', 'Nu', 'Johny Lee', '1'),
('1005', '123456789', 'Binh Dinh', '1996-10-20', 'Nu', 'Tam Le', '1'),
('2011', '123617846', 'Bac Giang', '2003-08-15', 'Nam', 'Long Ma', '2'),
('2013', '111222333', 'Vung Tau', '2000-12-31', 'Nu', 'Tuan Pham', '2'),
('2017', '188989763', 'Dak Lak', '2003-02-08', 'Nam', 'Bing Chilling', '2'),
('2019', '198769876', 'Hai Duong', '2005-06-16', 'Nam', 'Banh Dau Xanh', '2'),
('3011', '155566778', 'Ninh Binh', '2003-05-08', 'Nam', 'Bun Thit Nuong', '3'),
('3022', '177123111', 'Ha Nam', '1999-01-01', 'Nu', 'Dung Tran', '3'),
('3033', '123987423', 'Cao Bang', '2004-04-04', 'Nam', 'Do Phung', '3'),
 ('3044', '123433444', 'Hai Phong', '1998-01-01', 'Nu', 'Gunny Lam', '3');

-- Nhan_vien_van_phong
INSERT INTO Nhan_vien_van_phong VALUES
('1005', '123456789', 6000000.00, 'Quan ly'),
('2011', '123617846', 5000000.00, 'quan ly'),
('3033', '123987423', 4500000.00, 'quan ly');

-- Nhan_vien_phuc_vu
INSERT INTO Nhan_vien_phuc_vu (Ma_so, CCCD, Ma_so_nhan_vien_giam_sat, CCCD_nhan_vien_giam_sat) VALUES 
('1001', '177123130', '1002', '133234444'),
('1002', '133234444', '1002', '133234444'),
('1003', '134545677', '1022', '133234444'),
('1004', '177777771', '1022', '133234444'),
('2013', '111222333', '2019', '198769876'),
('2017', '188989763', '2019', '198769876'),
('2019', '198769876', '2019', '198769876'),
('3011', '155566778', '3022', '177123111'),
('3022', '177123111', '3022', '177123111'),
('3044', '123433444', '3022', '177123111');

-- Nhan_vien_toan_thoi_gian
INSERT INTO Nhan_vien_toan_thoi_gian (Ma_so, CCCD, Luong_co_dinh) VALUES 
('1002', '133234444', 5000000.00),
('1003', '134545677', 5500000.00),
('1004', '177777771', 4562000.00),
('2013', '111222333', 6200000.00),
('2019', '198769876', 7000000.00),
('3022', '177123111', 4500000.00),
('3044', '123433444', 3800000.00);

-- Nhan_vien_ban_thoi_gian
INSERT INTO Nhan_vien_ban_thoi_gian VALUES 
('1001', '177123130', 22000.00 ),
('2017', '188989763', 24000.00 ),
('3011', '155566778', 22000.00 );

-- Ca_lam_viec
INSERT INTO Ca_lam_viec VALUES 
('1001', '177123130', '2023-11-22', '13:00', '18:00'),
('1001', '177123130', '2023-11-20', '13:00', '18:00'),
('1001', '177123130', '2023-11-21', '13:00', '18:00'),
('1001', '177123130', '2023-11-25', '13:00', '18:00'),
('1001', '177123130', '2023-11-24', '13:00', '18:00'),
('1001', '177123130', '2023-11-23', '20:00', '23:00'),
('1001', '177123130', '2023-11-23', '13:00', '18:00'),
('2017', '188989763', '2023-11-22', '05:00', '11:00'),
('2017', '188989763', '2023-11-23', '05:00', '11:00'),
('3011', '155566778', '2023-11-23', '05:30', '17:30'),
('1001', '177123130', '2023-11-26', '13:00', '18:00');

-- San_pham
INSERT INTO San_pham VALUES 
('100000', 112, 45000.000, 'Ao mua CircleK', 'CircleK', 'Trung Quoc', 'NiHaoMa', '2023-08-11', '2024-02-01'),
('100123', 120, 15000.000, 'Banh mi', 'King Do', 'Viet Nam', 'King Do', '2023-10-02', '2024-04-20'),
('111133', 200, 15000.000, 'RedBull', 'RedBull', 'Thai Lan', 'RedBull Thai', '2023-07-04', '2025-07-04'),
('112130', 150, 10000.000, 'C2 Chanh', 'C2', 'Viet Nam', 'URC Viet Nam', '2023-07-05', '2024-10-29'),
('112233', 100, 10000.000, 'CocaCola', 'Pepsi', 'Viet Nam', 'Pepsi.co', '2023-05-31', '2025-02-15'),
('121130', 30, 22000.000, 'Kem oc que Vani', 'GGCream', 'Trung Quoc', 'GuangChowCr', '2023-10-19', '2023-11-23'),
('121310', 110, 14000.000, 'Chan ga cay', 'XiaoXiao', 'Trung Quoc', 'ZhongLiCo', '2022-09-01', '2025-09-01'),
('144441', 300, 5000.000, 'Vo ke ngang 80tr', 'Campus', 'Singapore', 'Campus', '2013-11-24', '2025-03-31'),
('199999', 190, 20000.000, 'Sua tam Xmen', 'Romano', 'Singapore', 'RomanoCo', '2023-10-05', '2024-01-31'),
('200003', 10, 120000.000, 'Thuoc Tay', 'Ngoc Chau', 'Viet Nam', 'NACo', '2022-11-23', '2024-10-12'),
('211211', 210, 50000.000, 'But bi TL', 'Thien Long', 'Viet Nam', 'Thien Long Co', '2023-08-09', '2024-01-06'),
('224234', 150, 10000.000, 'Kokomi90', 'Hao han', 'Viet Nam', 'Acekook', '2023-08-01', '2024-06-23'),
('345678', 41, 90000.000, 'Kem cao rau', 'Gillete', 'Thai Lan', 'Gillete Co', '2023-08-19', '2024-04-27');

-- Hoa_my_pham
INSERT INTO Hoa_my_pham VALUES
('345678', 'My pham',  'Chai 100ml'),
('200003', 'Hoa_pham', 'Chai 300ml'),
('199999', 'My_pham',  'Chai 200ml');

-- Hang_hoa_khac
INSERT INTO Hang_hoa_khac VALUES
('144441', 'giay', '2g/sqrcm', '23*17*5cm'),
('211211', 'nhua', '5g/sqrcm', '15*5*3cm'),
('100000', 'nilon', '10g/sqrcm', '1*1,7*1,3m');

-- Thuc_pham
INSERT INTO Thuc_pham VALUES 
('111133', '130kcal', 'nuoc, duong, inositol, caffein, vitamin B2'),
('112130', '130kcal', 'nuoc, tra, duong, huong chanh'),
('112233', '80kcal', 'nuoc, duong, huong Coca, caffein'),
('224234', '260kcal', 'tinh bot, dau thuc vat, rau cu say'),
('100123', '300kcal', 'bot mi, duong, muoi'),
('121130', '110kcal', 'chan ga, huong lieu');

-- Do_an
INSERT INTO Do_an VALUES
('224234', '75'),
('100123', '135'),
('121130', '250');

-- Thuc_uong
INSERT INTO Thuc_uong VALUES
('111133', '330'),
('112130', '500'),
('112233', '550');

-- Hoa_don
INSERT INTO Hoa_don VALUES 
('1122', 'laocai1122', '2023-11-23', '0', NULL, NULL, '1003', '134545677', '1',NULL),
('1211', 'laocai1211', '2023-11-23', '0', NULL, '101', '1003', '134545677', '1',NULL),
('1233', 'laocai1233', '2023-11-23', '100017', NULL, NULL, '1001', '177123130', '1',NULL),
('2234', 'thongnhat2234', '2023-09-11', '100011', '111', NULL, '2017', '188989763', '2',NULL),
('2344', 'thongnhat2344', '2023-11-21', '100012', '113', '821', '2013', '111222333', '1',NULL),
('3235', 'bayhien3235', '2023-11-01', '100013', NULL, NULL, '1001', '177123130', '1',NULL),
('3443', 'bayhien3443', '2023-11-02', '100014', '114', '103', '1001', '177123130', '3',NULL);


-- Khach_hang
INSERT INTO Khach_hang VALUES
('0'),
('100011'),
('100012'),
('100013'),
('100014'),
('100017');

-- Thanh_vien
INSERT INTO Thanh_vien VALUES 
('100011', '0499190007', 'Giang A Phao', 'Nam', 150,'100011'),
('100012', '0488800443', 'Do Y Khoa', 'Nu', 50,'100012'),
('100013', '0452300414', 'Mai Tai Son', 'Nam',0, '100013'),
('100014', '0466540045', 'Ton Ngo Khong', 'Nam',0, '100014'),
('100017', '0588870047', 'Nguyen Bac Dau', 'Nu', 255,'100017');

-- Phieu_giam_gia
INSERT INTO Phieu_giam_gia VALUES 
('111', '0499190007', 5000, '100011'),
('112', '0488800443', 10000, '100012'),
('113', '0488800443', 15000, '100012'),
('114', '0466540045', 15000, '100014');

--------------------------------------------------------------------------














-----------------------------------------------------------------------------









-------------------------- Alter Table ---------------------------
ALTER TABLE Chi_nhanh
ADD CONSTRAINT 	fk_Chi_nhanh_Ma_so_quan_ly	FOREIGN KEY (Ma_so_quan_ly,CCCD_quan_ly) 
				REFERENCES Nhan_vien_van_phong(Ma_so,CCCD);
ALTER TABLE Cung_cap
ADD CONSTRAINT 	fk_Cung_cap_Ma_vach	FOREIGN KEY (Ma_vach)
				REFERENCES San_pham(Ma_vach);
ALTER TABLE Cung_cap
ADD	CONSTRAINT	fk_Cung_cap_Ma_so_nha_cung_cap	FOREIGN KEY (Ma_so_nha_cung_cap)
				REFERENCES Nha_cung_cap(Ma_so);

ALTER TABLE Email_chi_nhanh
ADD CONSTRAINT 	fk_Email_chi_nhanh_Ma_chi_nhanh	FOREIGN KEY (Ma_chi_nhanh)
				REFERENCES Chi_nhanh(Ma_chi_nhanh);
ALTER TABLE SDT_chi_nhanh
ADD CONSTRAINT 	fk_SDT_chi_nhanh_Ma_chi_nhanh	FOREIGN KEY (Ma_chi_nhanh)
				REFERENCES Chi_nhanh(Ma_chi_nhanh);

ALTER TABLE Hop_tac
ADD CONSTRAINT 	fk_Hop_tac_Ma_so_nha_cung_cap	FOREIGN KEY (Ma_so_nha_cung_cap)
				REFERENCES Nha_cung_cap(Ma_so);
ALTER TABLE Hop_tac
ADD	CONSTRAINT	fk_Hop_tac_Ma_chi_nhanh	FOREIGN KEY (Ma_chi_nhanh)
				REFERENCES Chi_nhanh(Ma_chi_nhanh);

ALTER TABLE Doanh_thu
ADD CONSTRAINT 	fk_Doanh_thu_Ma_chi_nhanh	FOREIGN KEY (Ma_chi_nhanh)
				REFERENCES Chi_nhanh(Ma_chi_nhanh);

ALTER TABLE Khu_vuc_ngoi
ADD CONSTRAINT 	fk_Khu_vuc_ngoi_Ma_chi_nhanh	FOREIGN KEY (Ma_chi_nhanh)
				REFERENCES Chi_nhanh(Ma_chi_nhanh);

-----------------------------------------------------------

ALTER TABLE Chuong_trinh_khuyen_mai
ADD CONSTRAINT fk_Chuong_trinh_khuyen_mai_Chi_nhanh_Ma_chi_nhanh
FOREIGN KEY (Ma_chi_nhanh) REFERENCES Chi_nhanh(Ma_chi_nhanh);

ALTER TABLE COMBO
ADD CONSTRAINT fk_COMBO_Chuong_trinh_khuyen_mai_Ma_chuong_trinh
FOREIGN KEY (Ma_chuong_trinh) REFERENCES Chuong_trinh_khuyen_mai(Ma_chuong_trinh);

ALTER TABLE Khuyen_mai_theo_don_hang
ADD CONSTRAINT fk_Khuyen_mai_theo_don_hang_Ma_chuong_trinh
FOREIGN KEY (Ma_chuong_trinh) REFERENCES Chuong_trinh_khuyen_mai(Ma_chuong_trinh);

ALTER TABLE Khuyen_mai_theo_so_tien
ADD CONSTRAINT fk_Khuyen_mai_theo_so_tien_Ma_chuong_trinh
FOREIGN KEY (Ma_chuong_trinh) REFERENCES Khuyen_mai_theo_don_hang(Ma_chuong_trinh);

ALTER TABLE Khuyen_mai_theo_phan_tram
ADD CONSTRAINT fk_Khuyen_mai_theo_phan_tram_Ma_chuong_trinh
FOREIGN KEY (Ma_chuong_trinh) REFERENCES Khuyen_mai_theo_don_hang(Ma_chuong_trinh);

ALTER TABLE Bao_gom
ADD CONSTRAINT fk_Bao_gom_San_pham_Ma_vach
FOREIGN KEY (Ma_vach) REFERENCES San_pham(Ma_vach);
ALTER TABLE Bao_gom
ADD CONSTRAINT fk_Bao_gom_COMBO_Ma_chuong_trinh
FOREIGN KEY (Ma_chuong_trinh) REFERENCES COMBO(Ma_chuong_trinh);

ALTER TABLE Gom_combo
ADD CONSTRAINT fk_Gom_combo_Hoa_don_So_hoa_don
FOREIGN KEY (So_hoa_don) REFERENCES Hoa_don(So_hoa_don) ON DELETE CASCADE;
ALTER TABLE Gom_combo
ADD CONSTRAINT fk_Gom_combo_COMBO_Ma_combo
FOREIGN KEY (Ma_combo) REFERENCES COMBO(Ma_chuong_trinh);

ALTER TABLE Gom_san_pham
ADD CONSTRAINT fk_Gom_san_pham_Hoa_don_So_hoa_don
FOREIGN KEY (So_hoa_don) REFERENCES Hoa_don(So_hoa_don) ON DELETE CASCADE;
ALTER TABLE Gom_san_pham
ADD CONSTRAINT fk_Gom_san_pham_San_pham_Ma_vach
FOREIGN KEY (Ma_vach) REFERENCES San_pham(Ma_vach);
-----------------------------------------------------------

ALTER TABLE Nhan_vien
ADD CONSTRAINT Nhan_vien_Ma_chi_nhanh FOREIGN KEY (Ma_chi_nhanh) REFERENCES Chi_nhanh(Ma_chi_nhanh) ON DELETE CASCADE;

ALTER TABLE Email_nhan_vien
ADD CONSTRAINT fk_Email_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien(Ma_so,CCCD) ON DELETE CASCADE;
	
ALTER TABLE SDT_nhan_vien
ADD CONSTRAINT Sdt_nhan_vien_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien(Ma_so,CCCD) ON DELETE CASCADE;

ALTER TABLE Nhan_vien_van_phong
ADD CONSTRAINT Nhan_vien_van_phong_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien(Ma_so,CCCD) ON DELETE CASCADE;

ALTER TABLE Nhan_vien_phuc_vu
ADD CONSTRAINT Nhan_vien_phuc_vu_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien(Ma_so,CCCD) ON DELETE CASCADE;

ALTER TABLE Nhan_vien_toan_thoi_gian
ADD CONSTRAINT Nhan_vien_toan_thoi_gian_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien_phuc_vu(Ma_so,CCCD) ON DELETE CASCADE;

ALTER TABLE Nhan_vien_ban_thoi_gian
ADD CONSTRAINT Nhan_vien_ban_thoi_gian_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien_phuc_vu(Ma_so,CCCD) ON DELETE CASCADE;
ALTER TABLE Ca_lam_viec
ADD CONSTRAINT Ca_lam_viec_maso FOREIGN KEY (Ma_so,CCCD) REFERENCES Nhan_vien_ban_thoi_gian(Ma_so,CCCD) ON DELETE CASCADE;

-----------------------------------------------


ALTER TABLE Hoa_my_pham
ADD CONSTRAINT fk_Hoa_my_pham_Ma_vach FOREIGN KEY (Ma_vach) REFERENCES San_pham(Ma_vach);

ALTER TABLE Hang_hoa_khac
ADD CONSTRAINT fk_Hang_hoa_khac_Ma_vach FOREIGN KEY (Ma_vach) REFERENCES San_pham(Ma_vach);

ALTER TABLE Thuc_pham
ADD CONSTRAINT fk_Thuc_pham_Ma_vach FOREIGN KEY (Ma_vach) REFERENCES San_pham(Ma_vach);

ALTER TABLE Do_an
ADD CONSTRAINT fk_Do_an_Ma_vach FOREIGN KEY (Ma_vach) REFERENCES Thuc_pham(Ma_vach);

ALTER TABLE Thuc_uong
ADD CONSTRAINT fk_Thuc_uong_Ma_vach FOREIGN KEY (Ma_vach) REFERENCES Thuc_pham(Ma_vach);

ALTER TABLE Hoa_don
ADD CONSTRAINT fk_Hoa_don_Ma_khach_hang FOREIGN KEY (Ma_khach_hang) REFERENCES Khach_hang(Ma_khach_hang);
ALTER TABLE Hoa_don
ADD	CONSTRAINT fk_Hoa_don_Ma_giam_gia FOREIGN KEY (Ma_giam_gia) REFERENCES Phieu_giam_gia(Ma_giam_gia);
ALTER TABLE Hoa_don
ADD	CONSTRAINT fk_Hoa_don_Ma_chuong_trinh FOREIGN KEY (Ma_chuong_trinh) REFERENCES Khuyen_mai_theo_don_hang(Ma_chuong_trinh);
ALTER TABLE Hoa_don
ADD	CONSTRAINT fk_Hoa_don_Ma_so_nhan_vien_duyet 
		FOREIGN KEY (Ma_so_nhan_vien_duyet,CCCD_nhan_vien_duyet) REFERENCES Nhan_vien_phuc_vu(Ma_so,CCCD);
ALTER TABLE Hoa_don
ADD	CONSTRAINT fk_Hoa_don_Ma_chi_nhanh FOREIGN KEY (Ma_chi_nhanh) REFERENCES Chi_nhanh(Ma_chi_nhanh);

ALTER TABLE Thanh_vien
ADD CONSTRAINT fk_Thanh_vien_Ma_khach_hang FOREIGN KEY (Ma_khach_hang) REFERENCES Khach_hang(Ma_khach_hang);

ALTER TABLE Phieu_giam_gia
ADD CONSTRAINT fk_Phieu_giam_gia_Ma_thanh_vien FOREIGN KEY (Ma_thanh_vien,CCCD) REFERENCES Thanh_vien(Ma_thanh_vien,CCCD);
