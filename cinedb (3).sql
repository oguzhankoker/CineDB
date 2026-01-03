/*
📁 Bölüm: Database (SQL Dump)
📄 Amaç: Veritabanı şema ve yedek dosyası
🔗 İlişkili: config.php, veritabanı tabloları
⚙️ Özet: DB tabloları ve başlangıç verilerini içeren SQL dökümü
*/
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 Ara 2025, 21:09:49
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `cinedb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `diziler`
--

CREATE TABLE `diziler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `yil` int(4) NOT NULL,
  `poster` varchar(500) NOT NULL,
  `kategori` varchar(50) DEFAULT 'all',
  `bolum_sayisi` int(11) DEFAULT NULL,
  `sezon_sayisi` int(11) DEFAULT NULL,
  `tur` varchar(255) DEFAULT NULL,
  `imdb_puani` decimal(3,1) DEFAULT NULL,
  `ozet` text DEFAULT NULL,
  `yonetmen` varchar(255) DEFAULT NULL,
  `yazar` varchar(255) DEFAULT NULL,
  `basroller` varchar(500) DEFAULT NULL,
  `ulke` varchar(100) DEFAULT NULL,
  `fragman_url` varchar(500) DEFAULT NULL,
  `one_cikan` tinyint(1) DEFAULT 0,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `basrollers` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `diziler`
--

INSERT INTO `diziler` (`id`, `baslik`, `yil`, `poster`, `kategori`, `bolum_sayisi`, `sezon_sayisi`, `tur`, `imdb_puani`, `ozet`, `yonetmen`, `yazar`, `basroller`, `ulke`, `fragman_url`, `one_cikan`, `eklenme_tarihi`, `basrollers`) VALUES
(1, 'Breaking Bad', 2008, 'https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg', 'featured', 62, 5, 'Suç, Drama', 9.5, 'Kanser teşhisi sonrası ailesinin geleceğini güvenceye almak için eski öğrencisiyle metamfetamin üretmeye başlayan kimya öğretmeni Walter White\'ın hikayesi.', 'Vince Gilligan', 'Vince Gilligan', NULL, 'ABD', 'https://www.youtube.com/watch?v=HhesaQXLuRY', 1, '2025-11-24 11:46:09', 'Bryan Cranston, Aaron Paul'),
(2, 'Game of Thrones', 2011, 'https://image.tmdb.org/t/p/w500/u3bZgnGQ9T01sWNhyveQz0wH0Hl.jpg', 'featured', 73, 8, 'Fantastik, Macera, Drama', 9.2, 'Demir Taht için verilen acımasız mücadeleyi anlatan epik bir fantastik dizi.', 'David Benioff', 'George R. R. Martin', NULL, 'ABD', 'https://www.youtube.com/watch?v=KPLWWIOCOOQ', 1, '2025-11-24 11:46:09', 'Emilia Clarke, Kit Harington'),
(3, 'Dark', 2017, 'https://media.trakt.tv/images/shows/000/123/775/posters/medium/d7a032a36f.jpg.webp', 'featured', 26, 3, 'Bilim Kurgu, Gizem, Drama', 8.7, 'Kayıp bir çocuğun ardından dört aile arasındaki gizli ilişkiler ve zaman döngüleri ortaya çıkar.', 'Baran bo Odar', 'Jantje Friese', NULL, 'Almanya', 'https://www.youtube.com/watch?v=rrwycJ08PSA', 1, '2025-11-24 11:46:09', 'Louis Hofmann, Karoline Eichhorn'),
(5, 'Stranger Things', 2016, 'https://image.tmdb.org/t/p/w500/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg', 'all', 34, 4, 'Bilim Kurgu, Korku', 8.7, '80\'lerde geçen, kaybolan bir çocuk ve gizli deneylerin ortaya çıktığı gizemli olayları anlatır.', 'The Duffer Brothers', 'The Duffer Brothers', NULL, 'ABD', 'https://www.youtube.com/watch?v=mnd7sFt5c3A', 0, '2025-11-24 11:46:09', 'Millie Bobby Brown, Finn Wolfhard'),
(6, 'La Casa de Papel', 2017, 'https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg', 'all', 41, 5, 'Suç, Gerilim', 8.2, 'Profesör liderliğinde bir grup soyguncu İspanya Kraliyet Darphanesi\'ni soyar.', 'Álex Pina', 'Álex Pina', NULL, 'İspanya', 'https://www.youtube.com/watch?v=ZAXA1DV4dtI', 0, '2025-11-24 11:46:09', 'Úrsula Corberó, Álvaro Morte'),
(7, 'Peaky Blinders', 2013, 'https://image.tmdb.org/t/p/w500/vUUqzWa2LnHIVqkaKVlVGkVcZIW.jpg', 'all', 36, 6, 'Suç, Drama', 8.8, '1900\'lerin başında İngiltere\'de Shelby ailesinin yükselişini anlatır.', 'Steven Knight', 'Steven Knight', NULL, 'İngiltere', 'https://www.youtube.com/watch?v=oVzVdvGIC7U', 0, '2025-11-24 11:46:09', 'Cillian Murphy, Paul Anderson'),
(8, 'The Boys', 2019, 'https://image.tmdb.org/t/p/w500/stTEycfG9928HYGEISBFaG1ngjM.jpg', 'all', 24, 3, 'Aksiyon, Kara Mizah', 8.7, 'Gerçek yüzü karanlık olan süper kahramanlara karşı savaşan bir grubun hikayesi.', 'Eric Kripke', 'Eric Kripke', NULL, 'ABD', 'https://www.youtube.com/watch?v=06rueu_fh30', 0, '2025-11-24 11:46:09', 'Karl Urban, Antony Starr'),
(9, 'Sherlock', 2010, 'https://media.trakt.tv/images/shows/000/019/792/posters/medium/300ab0483b.jpg.webp', 'featured', 13, 4, 'Gizem, Suç', 9.1, 'Modern zamanda geçen Sherlock Holmes uyarlaması.', 'Mark Gatiss', 'Steven Moffat', NULL, 'İngiltere', 'https://www.youtube.com/watch?v=IrBKwzL3K7s', 1, '2025-11-24 11:46:09', 'Benedict Cumberbatch, Martin Freeman'),
(10, 'The Mandalorian', 2019, 'https://image.tmdb.org/t/p/w500/sWgBv7LV2PRoQgkxwlibdGXKz1S.jpg', 'all', 24, 3, 'Bilim Kurgu, Aksiyon', 8.6, 'Bir Mandalorian ödül avcısının galaksinin uzak bir köşesindeki maceraları.', 'Jon Favreau', 'Jon Favreau', NULL, 'ABD', 'https://www.youtube.com/watch?v=aOC8E8z_ifw', 0, '2025-11-24 11:46:09', 'Pedro Pascal'),
(11, 'Vikings', 2013, 'https://image.tmdb.org/t/p/w500/bQLrHIRNEkE3PdIWQrZHynQZazu.jpg', 'all', 89, 6, 'Aksiyon, Tarih', 8.5, 'Viking kahramanı Ragnar Lothbrok’un yükselişi.', 'Michael Hirst', 'Michael Hirst', NULL, 'Kanada', 'https://www.youtube.com/watch?v=9GgxinPwAGc', 0, '2025-11-24 11:46:09', 'Travis Fimmel, Katheryn Winnick'),
(12, 'The Last of Us', 2023, 'https://media.trakt.tv/images/shows/000/158/947/posters/medium/ddcfc6b5a2.jpg.webp', 'featured', 9, 1, 'Drama, Bilim Kurgu', 8.9, 'Kıyamet sonrası dünyada Joel ve Ellie’nin tehlikeli yolculuğu.', 'Craig Mazin', 'Neil Druckmann', NULL, 'ABD', 'https://www.youtube.com/watch?v=uLtkt8BonwM', 1, '2025-11-24 11:46:09', 'Pedro Pascal, Bella Ramsey'),
(13, 'The Umbrella Academy', 2019, 'https://media.trakt.tv/images/shows/000/137/198/posters/medium/4ebc6d892e.jpg.webp', 'all', 30, 3, 'Fantastik, Aksiyon', 7.9, 'Süper güçleri olan kardeşlerin gizemli olayları çözmeye çalışması.', 'Steve Blackman', 'Steve Blackman', NULL, 'ABD', 'https://www.youtube.com/watch?v=0DAmWHxeoKw', 0, '2025-11-24 11:46:09', 'Elliot Page, Tom Hopper'),
(14, 'Chernobyl', 2019, 'https://image.tmdb.org/t/p/w500/hlLXt2tOPT6RRnjiUmoxyG1LTFi.jpg', 'featured', 5, 1, 'Drama, Tarih', 9.4, '1986 Çernobil nükleer felaketini detaylı şekilde anlatan mini dizi.', 'Johan Renck', 'Craig Mazin', NULL, 'ABD, İngiltere', 'https://www.youtube.com/watch?v=s9APLXM9Ei8', 1, '2025-11-24 11:46:09', 'Jared Harris, Stellan Skarsgård'),
(15, 'Better Call Saul', 2015, 'https://image.tmdb.org/t/p/w500/fC2HDm5t0kHl7mTm7jxMR31b7by.jpg', 'all', 63, 6, 'Suç, Drama', 8.9, 'Breaking Bad\'in öncesini anlatan, Jimmy McGill\'in Saul Goodman\'a dönüş hikâyesi.', 'Vince Gilligan', 'Vince Gilligan', NULL, 'ABD', 'https://www.youtube.com/watch?v=HN4oydykJFc', 0, '2025-11-24 11:46:09', 'Bob Odenkirk, Rhea Seehorn'),
(16, 'Lost', 2004, 'https://media.trakt.tv/images/shows/000/004/583/posters/medium/197c82a123.jpg.webp', 'all', 121, 6, 'Macera, Gizem', 8.3, 'Uçak kazasından sağ kurtulan bir grup insan gizemli bir adada yaşam mücadelesi verir.', 'J.J. Abrams', 'J.J. Abrams', NULL, 'ABD', 'https://www.youtube.com/watch?v=KTu8iDynwNc', 0, '2025-11-24 11:46:09', 'Evangeline Lilly, Matthew Fox'),
(17, 'Mr. Robot', 2015, 'https://image.tmdb.org/t/p/w500/oKIBhzZzDX07SoE2bOLhq2EE8rf.jpg', 'all', 45, 4, 'Drama, Gerilim', 8.6, 'Hacker Elliot Alderson\'ın gizli bir hacker grubuna katılmasıyla değişen hayatı.', 'Sam Esmail', 'Sam Esmail', NULL, 'ABD', 'https://www.youtube.com/watch?v=xIBiJ_SzJTA', 0, '2025-11-24 11:46:09', 'Rami Malek, Christian Slater'),
(18, 'Mindhunter', 2017, 'https://media.trakt.tv/images/shows/000/116/965/posters/medium/987fb50472.jpg.webp', 'all', 19, 2, 'Suç, Drama', 8.6, 'FBI ajanları seri katillerin zihinlerini anlamaya çalışır.', 'Joe Penhall', 'Joe Penhall', NULL, 'ABD', 'https://www.youtube.com/watch?v=PHlJQCyqiaI', 0, '2025-11-24 11:46:09', 'Jonathan Groff, Holt McCallany'),
(19, 'House of the Dragon', 2022, 'https://media.trakt.tv/images/shows/000/154/574/posters/medium/5fea83a517.jpg.webp', 'featured', 10, 1, 'Fantastik, Drama, Aksiyon', 8.5, 'Taht Oyunları\'nın 200 yıl öncesini anlatan Targaryen hikayesi.', 'Ryan Condal', 'George R. R. Martin', NULL, 'ABD', 'https://www.youtube.com/watch?v=DotnJ7tTA34', 1, '2025-11-24 11:46:09', 'Emma D\'Arcy, Matt Smith'),
(20, 'The Walking Dead', 2010, 'https://image.tmdb.org/t/p/w500/xf9wuDcqlUPWABZNeDKPbZUjWx0.jpg', 'all', 177, 11, 'Korku, Drama', 8.2, 'Rick Grimes ve ekibinin zombi kıyametinde hayatta kalma savaşı.', 'Frank Darabont', 'Frank Darabont', NULL, 'ABD', 'https://www.youtube.com/watch?v=sfAc2U20uyg', 0, '2025-11-24 11:46:09', 'Andrew Lincoln, Norman Reedus'),
(21, 'Prison Break', 2005, 'https://media.trakt.tv/images/shows/000/002/274/posters/medium/7f5b58486f.jpg.webp', 'all', 90, 5, 'Aksiyon, Gerilim', 8.3, 'Michael Scofield, suçsuz yere hapse atılan kardeşini kaçırmak için zekice bir plan yapar.', 'Paul Scheuring', 'Paul Scheuring', NULL, 'ABD', 'https://www.youtube.com/watch?v=AL9zLctDJaU', 0, '2025-11-24 11:46:09', 'Wentworth Miller, Dominic Purcell'),
(22, 'Narcos', 2015, 'https://image.tmdb.org/t/p/w500/rTmal9fDbwh5F0waol2hq35U4ah.jpg', 'all', 30, 3, 'Suç, Drama', 8.7, 'Pablo Escobar ve Kolombiya uyuşturucu kartellerinin yükseliş hikayesi.', 'Chris Brancato', 'Chris Brancato', NULL, 'ABD', 'https://www.youtube.com/watch?v=U7elNhHwgBU', 0, '2025-11-24 11:46:09', 'Wagner Moura, Pedro Pascal'),
(23, 'Loki', 2021, 'https://image.tmdb.org/t/p/w500/kEl2t3OhXc3Zb9FBh1AuYzRTgZp.jpg', 'featured', 12, 2, 'Bilim Kurgu, Fantastik', 8.3, 'Loki’nin zaman çizgisini bozarak TVA tarafından yakalanmasıyla başlayan macera.', 'Kate Herron', 'Michael Waldron', NULL, 'ABD', 'https://www.youtube.com/watch?v=nW948Va-l10', 1, '2025-11-24 11:46:09', 'Tom Hiddleston, Sophia Di Martino'),
(24, 'The Queen’s Gambit', 2020, 'https://image.tmdb.org/t/p/w500/zU0htwkhNvBQdVSIKB9s6hgVeFK.jpg', 'featured', 7, 1, 'Drama', 8.6, 'Satranç dahisi Beth Harmon’un hem başarı hem bağımlılıklarla mücadelesini anlatır.', 'Scott Frank', 'Scott Frank', NULL, 'ABD', 'https://www.youtube.com/watch?v=CDrieqwSdgI', 1, '2025-11-24 11:46:09', 'Anya Taylor-Joy');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dizi_oylar`
--

CREATE TABLE `dizi_oylar` (
  `id` int(11) NOT NULL,
  `dizi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `puan` tinyint(4) NOT NULL CHECK (`puan` between 1 and 5),
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dizi_oylar`
--

INSERT INTO `dizi_oylar` (`id`, `dizi_id`, `user_id`, `puan`, `tarih`) VALUES
(4, 2, 1, 5, '2025-12-18 11:37:18'),
(5, 1, 1, 5, '2025-12-18 11:37:24'),
(7, 12, 1, 2, '2025-12-18 11:37:32'),
(8, 5, 1, 4, '2025-12-18 11:37:42'),
(9, 20, 1, 5, '2025-12-18 11:37:48');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dizi_yorumlar`
--

CREATE TABLE `dizi_yorumlar` (
  `id` int(11) NOT NULL,
  `dizi_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filmler`
--

CREATE TABLE `filmler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) DEFAULT NULL,
  `yil` int(11) DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT 'all',
  `sure` int(11) DEFAULT NULL,
  `tur` varchar(100) DEFAULT NULL,
  `imdb_puani` decimal(2,1) DEFAULT NULL,
  `ozet` text DEFAULT NULL,
  `yonetmen` varchar(255) DEFAULT NULL,
  `yazar` varchar(255) DEFAULT NULL,
  `basroller` varchar(255) DEFAULT NULL,
  `ulke` varchar(100) DEFAULT NULL,
  `fragman_url` text DEFAULT NULL,
  `one_cikan` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `filmler`
--

INSERT INTO `filmler` (`id`, `baslik`, `yil`, `resim_url`, `kategori`, `sure`, `tur`, `imdb_puani`, `ozet`, `yonetmen`, `yazar`, `basroller`, `ulke`, `fragman_url`, `one_cikan`) VALUES
(1, 'The Shawshank Redemption', 1994, 'https://media.trakt.tv/images/movies/000/000/234/posters/medium/a97015926b.jpg.webp', 'featured', 142, 'Dram', 9.3, 'Masumiyetini korumaya çalışan iki mahkûmun dostluğu ve umudun gücü.', 'Frank Darabont', 'Stephen King, Frank Darabont', 'Tim Robbins, Morgan Freeman', 'ABD', 'https://www.youtube.com/embed/6hB3S9bIaco', 0),
(2, 'The Godfather', 1972, 'https://media.trakt.tv/images/movies/000/000/196/posters/medium/4436e95fee.jpg.webp', 'featured', 175, 'Suç • Dram', 9.2, 'Corleone ailesinin yükselişini ve ihanetlerle dolu gücünü anlatan epik mafya destanı.', 'Francis Ford Coppola', 'Mario Puzo, Francis Ford Coppola', 'Marlon Brando, Al Pacino, James Caan', 'ABD', 'https://www.youtube.com/embed/UaVTIH8mujA', 1),
(3, 'The Dark Knight', 2008, 'https://media.trakt.tv/images/movies/000/000/120/posters/medium/8369bf0d4a.jpg.webp', 'featured', 152, 'Aksiyon • Suç • Dram', 9.0, 'Batman, Gotham’ı anarşiyle tehdit eden Joker’e karşı mücadele eder.', 'Christopher Nolan', 'Jonathan Nolan, Christopher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart', 'ABD', 'https://www.youtube.com/embed/EXeTwQWrcwY', 1),
(4, 'The Godfather: Part II', 1974, 'https://media.trakt.tv/images/movies/000/000/198/posters/medium/f7cd5ab346.jpg.webp', 'featured', 202, 'Suç • Dram', 9.0, 'Corleone ailesinin geçmişine ve Michael Corleone’nin gücünü pekiştirmesine odaklanır.', 'Francis Ford Coppola', 'Mario Puzo, Francis Ford Coppola', 'Al Pacino, Robert De Niro, Diane Keaton', 'ABD', 'https://www.youtube.com/embed/9O1Iy9od7-A', 1),
(5, '12 Angry Men', 1957, 'https://media.trakt.tv/images/movies/000/000/309/posters/medium/0f0ddf5ef5.jpg.webp', 'featured', 96, 'Dram', 9.0, 'Bir cinayet davasında 12 jüri üyesinin adalet üzerine yaptığı yoğun tartışmalar.', 'Sidney Lumet', 'Reginald Rose', 'Henry Fonda, Lee J. Cobb', 'ABD', 'https://www.youtube.com/embed/_13J_9B5jEk', 1),
(6, 'The Lord of the Rings: The Return of the King', 2003, 'https://media.trakt.tv/images/movies/000/000/090/posters/medium/308c97714c.jpg.webp', 'featured', 201, 'Macera • Fantastik', 9.0, 'Orta Dünya’nın kaderini belirleyen son büyük savaşta Frodo yüzüğü yok etmeye çalışır.', 'Peter Jackson', 'J.R.R. Tolkien, Fran Walsh, Philippa Boyens', 'Elijah Wood, Viggo Mortensen, Ian McKellen', 'Yeni Zelanda', 'https://www.youtube.com/embed/r5X-hFf6Bwo', 1),
(7, 'Schindler\'s List', 1993, 'https://media.trakt.tv/images/movies/000/000/336/posters/medium/ea3fe02622.jpg.webp', 'featured', 195, 'Dram • Tarih', 9.0, 'Oskar Schindler, Yahudi işçileri kurtarmak için hayatını riske atar.', 'Steven Spielberg', 'Steven Zaillian', 'Liam Neeson, Ben Kingsley, Ralph Fiennes', 'ABD', 'https://www.youtube.com/embed/gG22XNhtnoY', 1),
(8, 'The Lord of the Rings: The Fellowship of the Ring', 2001, 'https://media.trakt.tv/images/movies/000/000/088/posters/medium/73a273048f.jpg.webp', 'featured', 178, 'Macera • Fantastik', 8.9, 'Yüzük Kardeşliği, Sauron’un kudret yüzüğünü yok etmek için tehlikeli bir yolculuğa çıkar.', 'Peter Jackson', 'J.R.R. Tolkien, Fran Walsh, Philippa Boyens', 'Elijah Wood, Ian McKellen, Orlando Bloom', 'Yeni Zelanda', 'https://www.youtube.com/embed/V75dMMIW2B4', 0),
(9, 'Pulp Fiction', 1994, 'https://media.trakt.tv/images/movies/000/000/554/posters/medium/354f1c9483.jpg.webp', 'featured', 154, 'Suç • Dram', 8.9, 'Birbirine bağlı suç hikayeleri Quentin Tarantino’nun eşsiz tarzıyla anlatılıyor.', 'Quentin Tarantino', 'Quentin Tarantino, Roger Avary', 'John Travolta, Uma Thurman, Samuel L. Jackson', 'ABD', 'https://www.youtube.com/embed/s7EdQ4FqbhY', 1),
(10, 'The Good, the Bad and the Ugly', 1966, 'https://media.trakt.tv/images/movies/000/000/341/posters/medium/127b564deb.jpg.webp', 'featured', 178, 'Vahşi Batı • Aksiyon', 8.8, 'Üç silahşör, gömülü bir altın hazinesini bulmak için yarışır.', 'Sergio Leone', 'Luciano Vincenzoni, Age & Scarpelli', 'Clint Eastwood, Eli Wallach, Lee Van Cleef', 'İtalya', 'https://www.youtube.com/embed/WCN5JJY_wiA', 0),
(11, 'Forrest Gump', 1994, 'https://media.trakt.tv/images/movies/000/000/009/posters/medium/6d4da676cc.jpg.webp', 'featured', 142, 'Dram • Romantik', 8.8, 'Düşük IQ’suna rağmen, Forrest Gump olağanüstü bir hayata imza atar.', 'Robert Zemeckis', 'Winston Groom, Eric Roth', 'Tom Hanks, Robin Wright, Gary Sinise', 'ABD', 'https://www.youtube.com/embed/bLvqoHBptjg', 1),
(12, 'The Lord of the Rings: The Two Towers', 2002, 'https://media.trakt.tv/images/movies/000/000/089/posters/medium/20019dee8d.jpg.webp', 'all', 179, 'Macera • Fantastik', 8.8, 'Frodo ve Sam yüzükle yollarına devam ederken, diğerleri savaşa hazırlanır.', 'Peter Jackson', 'J.R.R. Tolkien, Fran Walsh, Philippa Boyens', 'Elijah Wood, Sean Astin, Viggo Mortensen', 'Yeni Zelanda', 'https://www.youtube.com/embed/LbfMDwc4azU', 0),
(13, 'Fight Club', 1999, 'https://media.trakt.tv/images/movies/000/000/432/posters/medium/7eb46b87e2.jpg.webp', 'all', 139, 'Dram • Gerilim', 8.8, 'Bir ofis çalışanı gizli dövüş kulübüyle hayatının yönünü değiştirir.', 'David Fincher', 'Chuck Palahniuk, Jim Uhls', 'Brad Pitt, Edward Norton, Helena Bonham Carter', 'ABD', 'https://www.youtube.com/embed/qtRKdVHc-cE', 1),
(14, 'Inception', 2010, 'https://media.trakt.tv/images/movies/000/016/662/posters/medium/c44164118c.jpg.webp', 'all', 148, 'Bilim Kurgu • Aksiyon', 8.8, 'Rüya içinde rüya kavramıyla zihin hırsızlığı yapan bir ekibin öyküsü.', 'Christopher Nolan', 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page', 'ABD', 'https://www.youtube.com/embed/YoHD9XEInc0', 1),
(15, 'The Empire Strikes Back', 1980, 'https://media.trakt.tv/images/movies/000/001/266/posters/medium/33004e8ae5.jpg.webp', 'all', 124, 'Bilim Kurgu • Macera', 8.7, 'Luke Skywalker, Darth Vader ile yüzleşmeye hazırlanırken isyan sürer.', 'Irvin Kershner', 'Leigh Brackett, Lawrence Kasdan', 'Mark Hamill, Harrison Ford, Carrie Fisher', 'ABD', 'https://www.youtube.com/embed/JNwNXF9Y6kY', 0),
(16, 'The Matrix', 1999, 'https://media.trakt.tv/images/movies/000/000/481/posters/medium/373310d2ee.jpg.webp', 'all', 136, 'Bilim Kurgu • Aksiyon', 8.7, 'Neo, yaşadığı dünyanın bir simülasyon olduğunu keşfeder.', 'Lana Wachowski, Lilly Wachowski', 'Lana Wachowski, Lilly Wachowski', 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss', 'ABD', 'https://www.youtube.com/embed/vKQi3bBA1y8', 1),
(17, 'GoodFellas', 1990, 'https://media.trakt.tv/images/movies/000/000/612/posters/medium/544a46a1c0.jpg.webp', 'all', 146, 'Suç • Biyografi', 8.7, 'Gerçek bir mafya mensubunun yükseliş ve düşüş hikayesi.', 'Martin Scorsese', 'Nicholas Pileggi, Martin Scorsese', 'Ray Liotta, Robert De Niro, Joe Pesci', 'ABD', 'https://www.youtube.com/embed/2ilzidi_J8Q', 0),
(18, 'Interstellar', 2014, 'https://media.trakt.tv/images/movies/000/102/156/posters/medium/7fcf530e15.jpg.webp', 'all', 169, 'Bilim Kurgu • Dram', 8.6, 'İnsanlığın geleceği için uzayda yeni yaşanabilir gezegenler aranır.', 'Christopher Nolan', 'Jonathan Nolan, Christopher Nolan', 'Matthew McConaughey, Anne Hathaway, Jessica Chastain', 'ABD', 'https://www.youtube.com/embed/zSWdZVtXT7E', 0),
(19, 'One Flew Over the Cuckoo\'s Nest', 1975, 'https://media.trakt.tv/images/movies/000/000/402/posters/medium/e60af2d6db.jpg.webp', 'all', 133, 'Dram', 8.7, 'Bir akıl hastanesinde özgürlüğün ve başkaldırının sembolü olan bir adam.', 'Milos Forman', 'Lawrence Hauben, Bo Goldman', 'Jack Nicholson, Louise Fletcher, Danny DeVito', 'ABD', 'https://www.youtube.com/embed/OXrcDonY-B8', 0),
(20, 'Se7en', 1995, 'https://media.trakt.tv/images/movies/000/000/650/posters/medium/69872078fd.jpg.webp', 'all', 127, 'Suç • Gerilim', 8.6, 'Yedi ölümcül günah temalı cinayetleri araştıran iki dedektifin hikayesi.', 'David Fincher', 'Andrew Kevin Walker', 'Brad Pitt, Morgan Freeman, Kevin Spacey', 'ABD', 'https://www.youtube.com/embed/znmZoVkCjpI', 0),
(21, 'It\'s a Wonderful Life', 1946, 'https://media.trakt.tv/images/movies/000/001/040/posters/medium/c11f1cd633.jpg.webp', 'all', 130, 'Dram • Aile', 8.6, 'Umudunu kaybetmiş bir adam, hayatının değerini keşfeder.', 'Frank Capra', 'Frances Goodrich, Albert Hackett', 'James Stewart, Donna Reed', 'ABD', 'https://www.youtube.com/embed/iLR3gZrU2Xo', 0),
(22, 'The Silence of the Lambs', 1991, 'https://media.trakt.tv/images/movies/000/000/230/posters/medium/496f1a8bf5.jpg.webp', 'all', 118, 'Gerilim • Suç', 8.6, 'Genç bir FBI ajanı, Hannibal Lecter’dan bir seri katili yakalamak için yardım ister.', 'Jonathan Demme', 'Thomas Harris, Ted Tally', 'Jodie Foster, Anthony Hopkins', 'ABD', 'https://www.youtube.com/embed/W6Mm8Sbe__o', 0),
(23, 'Seven Samurai', 1954, 'https://media.trakt.tv/images/movies/000/000/293/posters/medium/fabf0d90bc.jpg.webp', 'all', 207, 'Aksiyon • Dram', 8.6, 'Bir köyü haydutlardan korumak için yedi samuray görevlendirilir.', 'Akira Kurosawa', 'Akira Kurosawa, Shinobu Hashimoto', 'Toshirô Mifune, Takashi Shimura', 'Japonya', 'https://www.youtube.com/embed/wJ1TOratCTo', 0),
(24, 'Saving Private Ryan', 1998, 'https://media.trakt.tv/images/movies/000/000/700/posters/medium/496f16b86f.jpg.webp', 'all', 169, 'Savaş • Dram', 8.6, 'Normandiya çıkarmasında bir askeri kurtarmak için yola çıkan bir müfreze.', 'Steven Spielberg', 'Robert Rodat', 'Tom Hanks, Matt Damon, Tom Sizemore', 'ABD', 'https://www.youtube.com/embed/9CiW_DgxCnQ', 0),
(25, 'The Green Mile', 1999, 'https://media.trakt.tv/images/movies/000/000/390/posters/medium/b4a1bd9f5e.jpg.webp', 'all', 189, 'Dram • Fantastik • Suç', 8.6, 'Bir idam mahkumu, kendisine emanet edilen nazik bir devin gizemli bir yeteneğe sahip olduğunu öğrenir.', 'Frank Darabont', 'Stephen King, Frank Darabont', 'Tom Hanks, David Morse, Bonnie Hunt', 'ABD', 'https://www.youtube.com/embed/Bg7epsq0OIQ', 0),
(28, 'Gladiator', 2000, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'featured', 155, 'Aksiyon • Dram', 8.5, 'İhanete uğrayan bir Roma generali, gladyatör olarak intikam arar.', 'Ridley Scott', 'David Franzoni, John Logan', 'Russell Crowe, Joaquin Phoenix', 'ABD', 'https://www.youtube.com/embed/owK1qxDselE', 1),
(29, 'The Prestige', 2006, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 130, 'Dram • Gizem • Bilim Kurgu', 8.5, 'İki sihirbazın saplantılı rekabeti ölümcül bir hal alır.', 'Christopher Nolan', 'Jonathan Nolan, Christopher Nolan', 'Christian Bale, Hugh Jackman', 'ABD', 'https://www.youtube.com/embed/o4gHCmTQDVI', 1),
(30, 'Whiplash', 2014, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 106, 'Dram • Müzik', 8.5, 'Genç bir davulcu ile acımasız eğitmeni arasındaki psikolojik savaş.', 'Damien Chazelle', 'Damien Chazelle', 'Miles Teller, J.K. Simmons', 'ABD', 'https://www.youtube.com/embed/7d_jQycdQGo', 1),
(31, 'Parasite', 2019, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 132, 'Dram • Gerilim', 8.5, 'İki farklı sınıfa ait ailenin kesişen hayatları.', 'Bong Joon-ho', 'Bong Joon-ho, Han Jin-won', 'Song Kang-ho, Lee Sun-kyun', 'Güney Kore', 'https://www.youtube.com/embed/5xH0HfJHsaY', 1),
(32, 'Joker', 2019, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 122, 'Suç • Dram • Gerilim', 8.4, 'Toplumdan dışlanan bir adamın Joker’e dönüşüm hikayesi.', 'Todd Phillips', 'Todd Phillips, Scott Silver', 'Joaquin Phoenix', 'ABD', 'https://www.youtube.com/embed/zAGVQLHvwOY', 1),
(33, 'Avengers: Infinity War', 2018, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 149, 'Aksiyon • Fantastik • Bilim Kurgu', 8.4, 'Avengers, Thanos’un evreni yok etmesini durdurmaya çalışır.', 'Anthony Russo, Joe Russo', 'Christopher Markus, Stephen McFeely', 'Robert Downey Jr., Chris Evans', 'ABD', 'https://www.youtube.com/embed/6ZfuNTqbHE8', 0),
(34, 'Avengers: Endgame', 2019, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 181, 'Aksiyon • Fantastik • Bilim Kurgu', 8.4, 'Evrenin kaderi için son savaş.', 'Anthony Russo, Joe Russo', 'Christopher Markus, Stephen McFeely', 'Robert Downey Jr., Chris Evans', 'ABD', 'https://www.youtube.com/embed/TcMBFSGVi1c', 0),
(35, 'The Departed', 2006, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 151, 'Suç • Gerilim', 8.5, 'Polis ve mafya arasındaki köstebek savaşı.', 'Martin Scorsese', 'William Monahan', 'Leonardo DiCaprio, Matt Damon', 'ABD', 'https://www.youtube.com/embed/iojhqm0JTW4', 0),
(36, 'Django Unchained', 2012, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 165, 'Dram • Western', 8.4, 'Bir köle, özgürlüğünü ve eşini kurtarmak için savaşır.', 'Quentin Tarantino', 'Quentin Tarantino', 'Jamie Foxx, Christoph Waltz', 'ABD', 'https://www.youtube.com/embed/0fUCuvNlOCg', 0),
(37, 'The Wolf of Wall Street', 2013, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 180, 'Biyografi • Suç • Komedi', 8.2, 'Jordan Belfort’un aşırı lüks ve suç dolu hayatı.', 'Martin Scorsese', 'Terence Winter', 'Leonardo DiCaprio, Jonah Hill', 'ABD', 'https://www.youtube.com/embed/iszwuX1AK6A', 0),
(38, 'Shutter Island', 2010, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 138, 'Gizem • Gerilim', 8.2, 'Bir akıl hastanesinde kaybolan hastanın esrarı.', 'Martin Scorsese', 'Laeta Kalogridis', 'Leonardo DiCaprio, Mark Ruffalo', 'ABD', 'https://www.youtube.com/embed/5iaYLCiq5RM', 0),
(39, 'Mad Max: Fury Road', 2015, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 120, 'Aksiyon • Macera', 8.1, 'Çorak bir dünyada hayatta kalma mücadelesi.', 'George Miller', 'George Miller, Brendan McCarthy', 'Tom Hardy, Charlize Theron', 'Avustralya', 'https://www.youtube.com/embed/hEJnMQG9ev8', 0),
(40, 'A Beautiful Mind', 2001, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 135, 'Biyografi • Dram', 8.2, 'Dahi matematikçi John Nash’in hayatı.', 'Ron Howard', 'Akiva Goldsman', 'Russell Crowe, Jennifer Connelly', 'ABD', 'https://www.youtube.com/embed/aS_d0Ayjw4o', 0),
(41, 'Blade Runner 2049', 2017, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 164, 'Bilim Kurgu • Dram', 8.0, 'Gelecekte bir Blade Runner sırrı ortaya çıkarır.', 'Denis Villeneuve', 'Hampton Fancher', 'Ryan Gosling', 'ABD', '', 0),
(42, 'The Lion King', 1994, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 88, 'Animasyon • Macera', 8.5, 'Genç bir aslan kral olmaya hazırlanır.', 'Roger Allers', 'Irene Mecchi', 'Matthew Broderick', 'ABD', '', 0),
(43, 'Terminator 2', 1991, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 137, 'Aksiyon • Bilim Kurgu', 8.5, 'İnsanlığı korumak için bir robot gönderilir.', 'James Cameron', 'James Cameron', 'Arnold Schwarzenegger', 'ABD', '', 0),
(44, 'Jurassic Park', 1993, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 127, 'Macera • Bilim Kurgu', 8.1, 'Dinozorlar kontrolden çıkar.', 'Steven Spielberg', 'Michael Crichton', 'Sam Neill', 'ABD', '', 0),
(45, 'The Social Network', 2010, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 120, 'Biyografi • Dram', 7.7, 'Facebook’un kuruluş hikayesi.', 'David Fincher', 'Aaron Sorkin', 'Jesse Eisenberg', 'ABD', '', 0),
(46, 'Inglourious Basterds', 2009, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 153, 'Aksiyon • Savaş', 8.3, 'Alternatif bir II. Dünya Savaşı.', 'Quentin Tarantino', 'Quentin Tarantino', 'Brad Pitt', 'ABD', '', 0),
(47, 'City of God', 2002, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 130, 'Suç • Dram', 8.6, 'Brezilya’da suçun yükselişi.', 'Fernando Meirelles', 'Paulo Lins', 'Alexandre Rodrigues', 'Brezilya', '', 0),
(48, 'WALL-E', 2008, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 98, 'Animasyon • Bilim Kurgu', 8.4, 'Yalnız bir robot dünyayı temizler.', 'Andrew Stanton', 'Andrew Stanton', 'Ben Burtt', 'ABD', '', 0),
(49, 'The Truman Show', 1998, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 103, 'Dram • Bilim Kurgu', 8.1, 'Bir adamın hayatı canlı yayındadır.', 'Peter Weir', 'Andrew Niccol', 'Jim Carrey', 'ABD', '', 0),
(50, 'La La Land', 2016, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 128, 'Dram • Müzik', 8.0, 'Hayaller ve aşk çatışır.', 'Damien Chazelle', 'Damien Chazelle', 'Ryan Gosling', 'ABD', '', 0),
(51, 'The Shining', 1980, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 146, 'Korku • Dram', 8.4, 'Bir otelde deliliğe sürüklenen adam.', 'Stanley Kubrick', 'Stephen King', 'Jack Nicholson', 'ABD', '', 0),
(52, 'No Country for Old Men', 2007, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 122, 'Suç • Gerilim', 8.1, 'Şiddet dolu bir kovalamaca.', 'Coen Kardeşler', 'Coen Kardeşler', 'Javier Bardem', 'ABD', '', 0),
(53, 'Oldboy', 2003, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 120, 'Dram • Gizem', 8.4, 'İntikam dolu bir hikâye.', 'Park Chan-wook', 'Hwang Jo-yun', 'Choi Min-sik', 'Güney Kore', '', 0),
(54, 'Amelie', 2001, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 122, 'Romantik • Komedi', 8.3, 'Paris’te masalsı bir hayat.', 'Jean-Pierre Jeunet', 'Guillaume Laurant', 'Audrey Tautou', 'Fransa', '', 0),
(55, 'Spirited Away', 2001, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 125, 'Animasyon • Fantastik', 8.6, 'Ruhlar diyarında bir yolculuk.', 'Hayao Miyazaki', 'Hayao Miyazaki', 'Rumi Hiiragi', 'Japonya', '', 0),
(56, 'Interstellar', 2014, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 169, 'Bilim Kurgu • Dram', 8.6, 'Uzayda insanlık için umut aranır.', 'Christopher Nolan', 'Jonathan Nolan', 'Matthew McConaughey', 'ABD', '', 0),
(57, 'Fight Club', 1999, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 139, 'Dram • Gerilim', 8.8, 'Kaos ve kimlik sorgulaması.', 'David Fincher', 'Chuck Palahniuk', 'Brad Pitt', 'ABD', '', 0),
(58, 'Forrest Gump', 1994, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 142, 'Dram • Romantik', 8.8, 'Sıradan bir adamın olağanüstü hayatı.', 'Robert Zemeckis', 'Eric Roth', 'Tom Hanks', 'ABD', '', 0),
(59, 'Matrix', 1999, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 136, 'Bilim Kurgu • Aksiyon', 8.7, 'Gerçeklik bir simülasyondur.', 'Wachowski', 'Wachowski', 'Keanu Reeves', 'ABD', '', 0),
(60, 'Se7en', 1995, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 127, 'Suç • Gerilim', 8.6, 'Yedi ölümcül günah.', 'David Fincher', 'Andrew Kevin Walker', 'Brad Pitt', 'ABD', '', 0),
(61, 'The Green Mile', 1999, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 189, 'Dram • Fantastik', 8.6, 'İdam mahkumunun mucizesi.', 'Frank Darabont', 'Stephen King', 'Tom Hanks', 'ABD', '', 0),
(62, 'The Pianist', 2002, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 150, 'Dram • Savaş', 8.5, 'Savaşta hayatta kalma.', 'Roman Polanski', 'Ronald Harwood', 'Adrien Brody', 'Polonya', '', 0),
(63, 'Glory', 1989, 'https://www.moviepostermem.com/images/products/74ab01b4-65a9-4b43-aa1e-f0994ce47295.jpg', 'all', 122, 'Savaş • Dram', 7.8, 'Amerikan iç savaşı.', 'Edward Zwick', 'Kevin Jarre', 'Denzel Washington', 'ABD', '', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `icerikler`
--

CREATE TABLE `icerikler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) DEFAULT NULL,
  `ozet` text DEFAULT NULL,
  `icerik` text DEFAULT NULL,
  `gorsel` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `tur` enum('haber','reklam') NOT NULL,
  `hedef` enum('film','dizi','genel') DEFAULT 'genel',
  `konum` enum('ust','yan','orta') DEFAULT 'orta',
  `aktif` tinyint(1) DEFAULT 1,
  `baslangic` datetime DEFAULT current_timestamp(),
  `bitis` datetime DEFAULT NULL,
  `olusturma_tarihi` datetime DEFAULT current_timestamp(),
  `tiklanma` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `icerikler`
--

INSERT INTO `icerikler` (`id`, `baslik`, `ozet`, `icerik`, `gorsel`, `link`, `tur`, `hedef`, `konum`, `aktif`, `baslangic`, `bitis`, `olusturma_tarihi`, `tiklanma`) VALUES
(1, 'Yeni Marvel Filmi Geliyor', 'Marvel evreninden bomba gibi bir film haberi', 'Marvel Studios yeni faz planını açıkladı...', 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Marvel_Logo.svg/1280px-Marvel_Logo.svg.png', NULL, 'haber', 'film', 'ust', 1, '2025-12-22 00:34:00', NULL, '2025-12-22 00:34:18', 0),
(3, 'Superman', 'James Gunn’ın Yeni \"Superman\" Filminde Brainiac\'ı Oynayacak Aktör Belli Oldu', 'Alman oyuncu Lars Eidinger, “Man of Tomorrow”da ikonik DC kötüsünü canlandıracak.\r\n', 'https://tr.web.img3.acsta.net/c_400_225/img/7a/ac/7aacb3b6220e40ce795ff88af4c54407.png', 'https://www.beyazperde.com/haberler/filmler/', 'haber', 'film', 'ust', 1, '2025-12-20 11:00:00', '2025-12-22 12:00:00', '2025-12-22 10:43:48', 0),
(4, ' 21 Aralık En Uzun Gecede Seyredilecek Filmler!', 'Haber görseliHaberler - İnternetten Seçtiklerimiz ', '21 Aralık En Uzun Gecede Seyredilecek Filmler!', 'https://tr.web.img4.acsta.net/c_640_360/img/5f/aa/5faa6f11e5ce048dc70227e301886dee.jpg', NULL, 'haber', 'film', 'ust', 1, '2025-12-20 20:00:00', '2025-12-25 21:00:00', '2025-12-22 10:58:20', 0),
(5, '2025’in En İyi Komedi Filmleri ', 'Gündemdeki Filmler 2025’in En İyi Komedi Filmleri', 'haber görseli', 'https://tr.web.img3.acsta.net/c_640_360/img/f9/00/f900de8ff03c105dbc97d4bd5ae314cc.png', 'https://www.beyazperde.com/haberler/filmler/', 'haber', 'genel', 'ust', 1, '2025-12-20 12:00:00', '2025-12-28 10:00:00', '2025-12-22 11:02:39', 0),
(6, 'Netflix', 'daha fazla bilgi için tıkla...', '', 'https://wallpaperaccess.com/full/2772922.png', 'https://t4.ftcdn.net/jpg/03/48/81/79/240_F_348817927_Tbw7kvp6JFQHejttMG13kNnyKSII0bXK.jpg', 'reklam', 'genel', 'ust', 1, '2025-12-22 13:35:00', '2026-01-02 00:00:00', '2025-12-22 13:33:05', 1),
(7, '2. Uluslararası Afet Film Festivali’nde Ödüller Sahiplerini Buldu', 'Festival ve Ödüller', '2. Uluslararası Afet Film Festivali’nde Ödüller Sahiplerini Buldu2. Uluslararası Afet Film Festivali’nde Ödüller Sahiplerini Buldu haber görseliHaberler - Festival ve Ödüller\r\n2. Uluslararası Afet Film Festivali’nde Ödüller Sahiplerini Buldu2. Uluslararası Afet Film Festivali’nde Ödüller Sahiplerini Buldu haber görseliHaberler - Festival ve Ödüller\r\n2. Uluslararası Afet Film Festivali’nde Ödüller Sahiplerini Buldu\r\n', 'https://tr.web.img4.acsta.net/c_640_360/img/57/58/575817702cd73e3e7a00c8a378d79540.png', 'https://www.beyazperde.com/haberler/filmler/', 'haber', 'film', 'ust', 1, '2025-12-22 10:00:00', '2025-12-31 23:59:00', '2025-12-22 14:14:02', 0),
(8, 'IMDB', 'daha fazla bilgi için tıkla...', '', 'https://m.media-amazon.com/images/M/MV5BYTY4Y2RlZmQtZjQwZi00M2NjLThjY2UtZmExOGJmNmIxZmI0XkEyXkFqcGc@._V1_QL75_UY281_CR42,0,500,281_.jpg', 'https://www.imdb.com/', 'reklam', 'film', 'ust', 1, '2025-12-20 12:50:00', '2026-01-28 20:00:00', '2025-12-22 14:16:44', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim_mesajlari`
--

CREATE TABLE `iletisim_mesajlari` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `iletisim_mesajlari`
--

INSERT INTO `iletisim_mesajlari` (`id`, `isim`, `email`, `mesaj`, `tarih`) VALUES
(5, 'Oğuz', 'kokeroguzhan45@gmail.com', 'merhaba bu bir denemedir...', '2025-12-19 15:01:51'),
(6, 'Oğuz', 'kokeroguzhan45@gmail.com', 'merhaba bu bir denemedir...', '2025-12-19 15:02:22'),
(7, 'Oğuz', 'kokeroguzhan45@gmail.com', 'merhaba bu bir denemedir...', '2025-12-19 15:02:35'),
(8, 'Oğuzhan KÖKER', 'kokeroguzhan64@gmail.com', 'sdfsfsdfsdf', '2025-12-21 23:11:28');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_kitaplik`
--

CREATE TABLE `kullanici_kitaplik` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `icerik_id` int(11) NOT NULL,
  `icerik_turu` enum('film','dizi') NOT NULL,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanici_kitaplik`
--

INSERT INTO `kullanici_kitaplik` (`id`, `user_id`, `icerik_id`, `icerik_turu`, `eklenme_tarihi`) VALUES
(2, 1, 5, 'film', '2025-12-17 07:37:22'),
(4, 1, 2, 'dizi', '2025-12-17 07:38:04'),
(10, 1, 4, 'film', '2025-12-22 07:00:48'),
(11, 1, 9, 'film', '2025-12-22 08:52:41'),
(12, 1, 12, 'dizi', '2025-12-22 08:52:54');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oylar`
--

CREATE TABLE `oylar` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `kullanici_adi` varchar(100) DEFAULT 'Anonim',
  `user_id` int(11) NOT NULL,
  `puan` int(11) NOT NULL CHECK (`puan` between 1 and 5),
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `oylar`
--

INSERT INTO `oylar` (`id`, `film_id`, `kullanici_adi`, `user_id`, `puan`, `tarih`) VALUES
(13, 2, 'Anonim', 1, 4, '2025-12-18 14:34:42'),
(14, 20, 'Anonim', 1, 4, '2025-12-18 14:34:50'),
(15, 23, 'Anonim', 1, 4, '2025-12-18 14:34:55'),
(16, 19, 'Anonim', 1, 5, '2025-12-18 14:35:02'),
(17, 19, 'Anonim', 3, 2, '2025-12-18 14:35:56'),
(19, 23, 'Anonim', 3, 3, '2025-12-18 14:36:30'),
(20, 20, 'Anonim', 3, 1, '2025-12-18 14:36:37'),
(21, 6, 'Anonim', 3, 4, '2025-12-18 15:07:48'),
(22, 9, 'Anonim', 1, 4, '2025-12-22 15:17:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token`, `expire`) VALUES
(8, 3, '26dbb06d6b8df4886b3413f7c8e86f3e4bdd1534edbe6a6a4c878e84a2c92a98', '2025-12-18 15:27:45');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `profil_resmi` varchar(255) DEFAULT 'default.png',
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `durum` tinyint(1) DEFAULT 1,
  `guncelleme_tarihi` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `kullanici_adi`, `email`, `sifre`, `profil_resmi`, `kayit_tarihi`, `role`, `durum`, `guncelleme_tarihi`) VALUES
(1, 'oguzhan', 'kokeroguzhan64@gmail.com', '$2y$10$t2wQQ.UTw1M/NkpOqbOpR.Ml/H8CJkFXclOQ0HMy7mRcGKH3/WOOy', 'default.png', '2025-10-30 17:37:00', 'admin', 1, '2025-12-17 11:08:07'),
(3, 'oguzhan123', 'kokeroguzhan45@gmail.com', '$2y$10$c04RHLxkPtQ5uCf4FqmMTOyncGnTBNlOXrXFEr1Ze07sTXaEVNrzO', 'default.png', '2025-12-17 20:30:21', 'user', 1, '2025-12-18 11:27:13'),
(5, 'fatih', 'fatih@gmail.com', '$2y$10$w6SgwEDa2JDyPSZeA0rLNeF7.CdcqdyM5.rOQvm88b/MKaLKtxjei', 'default.png', '2025-12-22 08:42:09', 'user', 1, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yakinda`
--

CREATE TABLE `yakinda` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `poster` varchar(500) NOT NULL,
  `tur` enum('film','dizi') NOT NULL,
  `aktif` tinyint(1) DEFAULT 1,
  `sira` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yakinda`
--

INSERT INTO `yakinda` (`id`, `baslik`, `poster`, `tur`, `aktif`, `sira`, `created_at`) VALUES
(6, 'Avatar: Fire and Ash', 'https://images.justwatch.com/poster/338795347/s166/avatar-3.avif', 'film', 1, 0, '2025-12-18 21:21:44'),
(7, 'Scream 7', 'https://images.justwatch.com/poster/338796418/s166/scream-7.avif', 'film', 1, 1, '2025-12-18 21:23:04'),
(8, 'Supergirl', 'https://images.justwatch.com/poster/339996464/s166/supergirl-woman-of-tomorrow.avif', 'film', 1, 2, '2025-12-18 21:28:15'),
(9, 'Avengers: Doomsday', 'https://images.justwatch.com/poster/327937882/s166/avengers-the-kang-dynasty.avif', 'film', 1, 3, '2025-12-18 21:29:17'),
(10, 'Avengers: Secret Wars', 'https://images.justwatch.com/poster/319495288/s166/avengers-secret-wars.avif', 'film', 1, 4, '2025-12-18 21:30:07'),
(11, 'Spider-Man: Brand New Day', 'https://images.justwatch.com/poster/328302920/s166/spider-man-4.avif', 'film', 1, 5, '2025-12-18 21:32:24'),
(13, 'Stranger Things: Tales from \'85', 'https://images.justwatch.com/poster/338401825/s166/stranger-things-sene-1985.avif', 'dizi', 1, 0, '2025-12-18 22:11:53'),
(14, 'Fallout', 'https://images.justwatch.com/poster/313866771/s166/fallout.avif', 'dizi', 1, 2, '2025-12-18 22:13:55'),
(15, 'he Tonight Show Starring Jimmy Fallon', 'https://images.justwatch.com/poster/324764891/s166/the-tonight-show-starring-jimmy-fallon.avif', 'dizi', 1, 3, '2025-12-18 22:17:14'),
(16, ' Adventure Time: Fionna & Cake', 'https://images.justwatch.com/poster/337276724/s166/adventure-time-fionna-ve-cake.avif', 'dizi', 1, 4, '2025-12-18 22:18:22'),
(18, 'Stranger Things', 'https://images.justwatch.com/poster/319431805/s166/stranger-things.avif', 'dizi', 1, 1, '2025-12-18 22:22:09'),
(19, 'IT: Welcome to Derry', 'https://images.justwatch.com/poster/338978773/s166/sezon-1.avif', 'dizi', 1, 5, '2025-12-18 22:23:20');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `dizi_id` int(11) DEFAULT NULL,
  `kullanici_adi` varchar(100) DEFAULT 'Anonim',
  `user_id` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `film_id`, `dizi_id`, `kullanici_adi`, `user_id`, `yorum`, `tarih`) VALUES
(20, 6, NULL, 'Anonim', 1, 'trrhtfrhtfgh', '2025-12-22 15:14:08');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `diziler`
--
ALTER TABLE `diziler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `dizi_oylar`
--
ALTER TABLE `dizi_oylar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tek_oy` (`dizi_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `dizi_yorumlar`
--
ALTER TABLE `dizi_yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `filmler`
--
ALTER TABLE `filmler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `icerikler`
--
ALTER TABLE `icerikler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `iletisim_mesajlari`
--
ALTER TABLE `iletisim_mesajlari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici_kitaplik`
--
ALTER TABLE `kullanici_kitaplik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `oylar`
--
ALTER TABLE `oylar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `yakinda`
--
ALTER TABLE `yakinda`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `diziler`
--
ALTER TABLE `diziler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `dizi_oylar`
--
ALTER TABLE `dizi_oylar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `dizi_yorumlar`
--
ALTER TABLE `dizi_yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `filmler`
--
ALTER TABLE `filmler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Tablo için AUTO_INCREMENT değeri `icerikler`
--
ALTER TABLE `icerikler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `iletisim_mesajlari`
--
ALTER TABLE `iletisim_mesajlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_kitaplik`
--
ALTER TABLE `kullanici_kitaplik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `oylar`
--
ALTER TABLE `oylar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `yakinda`
--
ALTER TABLE `yakinda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `dizi_oylar`
--
ALTER TABLE `dizi_oylar`
  ADD CONSTRAINT `dizi_oylar_ibfk_1` FOREIGN KEY (`dizi_id`) REFERENCES `diziler` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dizi_oylar_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `kullanici_kitaplik`
--
ALTER TABLE `kullanici_kitaplik`
  ADD CONSTRAINT `kullanici_kitaplik_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
