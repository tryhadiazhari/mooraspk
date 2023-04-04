--
-- Database: `mooraspk`
--
CREATE DATABASE IF NOT EXISTS `mooraspk` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mooraspk`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akun`
--

CREATE TABLE `tbl_akun` (
  `id` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_akun`
--

INSERT INTO `tbl_akun` (`id`, `username`, `password`, `level`) VALUES
('1', 'hrd', '$2y$10$FOTtx8rGDn.53NMbb6.jtuUdTn044jFbTtCUl4kZWU13sTKhvBTru', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_datapengacara`
--

CREATE TABLE `tbl_datapengacara` (
  `kode_pengacara` varchar(20) NOT NULL,
  `nik` bigint(16) NOT NULL,
  `nama_pengacara` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kriteria`
--

CREATE TABLE `tbl_kriteria` (
  `kode_kriteria` varchar(20) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `bobot_kriteria` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nilai`
--

CREATE TABLE `tbl_nilai` (
  `kode_nilai` varchar(20) NOT NULL,
  `kode_pengacara` varchar(20) NOT NULL,
  `kode_kriteria` varchar(20) NOT NULL,
  `bobot_penilaian` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penilaian`
--

CREATE TABLE `tbl_penilaian` (
  `kode_penilaian` int(20) NOT NULL,
  `kode_pengacara` varchar(10) NOT NULL,
  `kode_kriteria` varchar(10) NOT NULL,
  `nilai_akhir` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subkriteria`
--

CREATE TABLE `tbl_subkriteria` (
  `kode_subkriteria` varchar(20) NOT NULL,
  `nama_subkriteria` varchar(50) NOT NULL,
  `bobot_nilai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_akun`
--
ALTER TABLE `tbl_akun`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `tbl_datapengacara`
--
ALTER TABLE `tbl_datapengacara`
  ADD PRIMARY KEY (`kode_pengacara`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`),
  ADD UNIQUE KEY `nama_kriteria` (`nama_kriteria`);

--
-- Indexes for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  ADD PRIMARY KEY (`kode_nilai`);

--
-- Indexes for table `tbl_penilaian`
--
ALTER TABLE `tbl_penilaian`
  ADD PRIMARY KEY (`kode_penilaian`);

--
-- Indexes for table `tbl_subkriteria`
--
ALTER TABLE `tbl_subkriteria`
  ADD PRIMARY KEY (`kode_subkriteria`),
  ADD KEY `nama_subkriteria` (`nama_subkriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_penilaian`
--
ALTER TABLE `tbl_penilaian`
  MODIFY `kode_penilaian` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;
