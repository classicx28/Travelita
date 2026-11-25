-- Travelita database
CREATE DATABASE IF NOT EXISTS travelita CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE travelita;

CREATE TABLE packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  destination VARCHAR(120) NOT NULL,
  country VARCHAR(80) NOT NULL,
  category ENUM('international','national','cruise','honeymoon','group') DEFAULT 'international',
  duration_days TINYINT UNSIGNED NOT NULL,
  duration_nights TINYINT UNSIGNED NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  old_price DECIMAL(10,2) NULL,
  image VARCHAR(255) NULL,
  summary VARCHAR(300) NOT NULL,
  description TEXT,
  highlights TEXT,      -- one item per line
  itinerary TEXT,       -- JSON: [{"day":1,"title":"...","text":"..."}]
  includes TEXT,        -- one item per line
  excludes TEXT,        -- one item per line
  departure_dates VARCHAR(255) NULL,
  is_featured TINYINT(1) DEFAULT 0,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reference VARCHAR(20) NOT NULL UNIQUE,
  package_id INT NULL,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  nationality VARCHAR(80) NULL,
  travel_date DATE NULL,
  adults TINYINT UNSIGNED DEFAULT 1,
  children TINYINT UNSIGNED DEFAULT 0,
  message TEXT,
  status ENUM('pending','contacted','confirmed','cancelled') DEFAULT 'pending',
  admin_notes TEXT NULL,
  ip_address VARCHAR(45) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL,
  INDEX (status), INDEX (created_at)
) ENGINE=InnoDB;

CREATE TABLE newsletter (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(160) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Admin users (for the back-office you will build later)
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO packages (title, slug, destination, country, category, duration_days, duration_nights, price, old_price, image, summary, description, highlights, itinerary, includes, excludes, departure_dates, is_featured) VALUES
('Classic Paris & Swiss Alps','paris-swiss-alps','Paris & Interlaken','France / Switzerland','international',9,8,2490,2790,'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=70',
 'Eiffel Tower evenings, Montmartre mornings and a scenic rail journey into the heart of the Alps.',
 'A balanced journey through two of Europe''s most loved destinations, combining city culture with mountain landscapes.',
 'Seine river cruise
Guided Louvre visit
Jungfraujoch excursion
Golden Pass scenic train',
 '[{"day":1,"title":"Arrival in Paris","text":"Airport transfer and welcome dinner."},{"day":2,"title":"Paris city tour","text":"Eiffel Tower, Champs-Élysées and Seine cruise."},{"day":3,"title":"Louvre & Montmartre","text":"Guided museum visit and free afternoon."},{"day":4,"title":"Train to Interlaken","text":"TGV Lyria to Switzerland."},{"day":5,"title":"Jungfraujoch","text":"Top of Europe excursion."},{"day":6,"title":"Lucerne","text":"Chapel Bridge and lake cruise."}]',
 'Return flights
4★ hotels with breakfast
All transfers
English-speaking guide',
 'Visa fees
Travel insurance
Personal expenses','12 Mar 2027, 09 Apr 2027, 14 May 2027',1),
('Bali Island Escape','bali-island-escape','Ubud & Seminyak','Indonesia','honeymoon',7,6,1390,NULL,'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=70',
 'Rice terraces, temple sunsets and private pool villas on the Island of the Gods.',
 'A relaxed itinerary split between the cultural heart of Ubud and the beaches of Seminyak.',
 'Private pool villa
Tegallalang rice terraces
Uluwatu sunset & Kecak dance','[{"day":1,"title":"Arrival in Bali","text":"Private transfer to Ubud."},{"day":2,"title":"Ubud","text":"Monkey forest and rice terraces."}]',
 'Return flights
Villa with breakfast
Private driver','Visa on arrival
Lunches & dinners','Daily departures',1),
('Turkey Highlights','turkey-highlights','Istanbul & Cappadocia','Turkey','group',8,7,1190,1350,'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=1200&q=70',
 'Bosphorus views, the Grand Bazaar and a sunrise balloon flight over Cappadocia.',
 'Discover where East meets West, from Byzantine landmarks to fairy-chimney valleys.',
 'Hagia Sophia & Blue Mosque
Bosphorus cruise
Hot-air balloon (optional)','[{"day":1,"title":"Istanbul","text":"Arrival and transfer."}]',
 'Flights
Hotels with breakfast
Domestic flight','Balloon ride
Tips','02 Feb 2027, 06 Mar 2027',1),
('Maldives Overwater Retreat','maldives-retreat','North Malé Atoll','Maldives','honeymoon',6,5,2890,NULL,'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=1200&q=70',
 'Overwater villa, half-board dining and a seaplane arrival over turquoise lagoons.',
 'Five nights of quiet luxury on a private island resort.',
 'Overwater villa
Seaplane transfer
Snorkelling excursion','[{"day":1,"title":"Arrival","text":"Seaplane to the resort."}]',
 'Flights
Half board
Seaplane transfers','Spa treatments','Daily departures',1),
('Egypt: Cairo & Nile Cruise','egypt-nile-cruise','Cairo, Luxor & Aswan','Egypt','cruise',8,7,1590,NULL,'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=1200&q=70',
 'The Pyramids of Giza followed by four nights sailing the Nile between Luxor and Aswan.',
 'A classic journey through ancient Egypt with expert Egyptologist guides.',
 'Pyramids & Sphinx
5★ Nile cruise
Valley of the Kings','[{"day":1,"title":"Cairo","text":"Arrival and transfer."}]',
 'Flights
Full board on cruise
Egyptologist guide','Visa
Tips','15 Jan 2027, 12 Feb 2027',1),
('Japan Cherry Blossom','japan-cherry-blossom','Tokyo, Hakone & Kyoto','Japan','group',10,9,3590,3890,'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=70',
 'Travel Japan in sakura season, from neon Tokyo to the temples and tea houses of Kyoto.',
 'A small-group spring tour timed for the cherry blossom.',
 'Bullet train
Mt Fuji & Hakone
Kyoto temples','[{"day":1,"title":"Tokyo","text":"Arrival and transfer."}]',
 'Flights
Hotels with breakfast
JR Pass','Lunches & dinners','28 Mar 2027',1);
