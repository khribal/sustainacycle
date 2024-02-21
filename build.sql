drop table if exists articles;
drop table if exists user_transaction;
drop table if exists transactions;
drop table if exists user_community;
drop table if exists communities;
drop table if exists materials;
drop table if exists manufacturers;
drop table if exists recycler_materials;
drop table if exists recyclers;
drop table if exists users;

CREATE TABLE users(
    userID int NOT NULL AUTO_INCREMENT,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
    pass varchar(250) NOT NULL,
    contactNum VARCHAR(13),
    user_location varchar(50),
    usertype varchar(20) CHECK (usertype IN ('recycler', 'manufacturer', 'individual_user')),
    PRIMARY KEY (userID)
) ENGINE=INNODB;


CREATE TABLE recyclers(
    companyID int NOT NULL AUTO_INCREMENT,
    userID int NOT NULL,
    companyName varchar(50) NOT NULL,
    cAddress varchar(50),
    city varchar(50),
    cState varchar(50),
    zip int,
    lat decimal(9,7),
    lng decimal(10,7),
    PRIMARY KEY (companyID),
    FOREIGN KEY (userID) REFERENCES users(userID)
) engine=innodb;


CREATE TABLE recycler_materials(
    companyID int NOT NULL,
    acceptedMaterial varchar(50),
    FOREIGN KEY (companyID) REFERENCES recyclers(companyID)
) engine=innodb;


CREATE TABLE manufacturers(
     manufacturerID int NOT NULL AUTO_INCREMENT,
     companyName varchar(50) NOT NULL,
     userID int NOT NULL,
     cAddress varchar(50),
     city varchar(50),
     cState varchar(50),
     zip int,
     PRIMARY KEY (manufacturerID),
     FOREIGN KEY (userID) REFERENCES users(userID)
) engine=innodb;


CREATE TABLE materials(
    materialID int NOT NULL AUTO_INCREMENT,
    quantity int NOT NULL,
    materialName varchar(50),
    description TEXT NOT NULL,
    manufacturerID int NOT NULL,
    PRIMARY KEY (materialID),
    FOREIGN KEY (manufacturerID) REFERENCES manufacturers(manufacturerID)
) engine=innodb;


CREATE TABLE communities(
    communityID int NOT NULL AUTO_INCREMENT,
    communityName varchar(50) NOT NULL,
    communityDescription TEXT NOT NULL,
    communityRules TEXT NOT NULL,
    communityDescription TEXT not null,
    tags varchar(50) NOT NULL,
    PRIMARY KEY (communityID)
) engine=innodb;


CREATE TABLE user_community(
     userID int NOT NULL,
     communityID int NOT NULL,
     FOREIGN KEY (userID) REFERENCES users(userID),
     FOREIGN KEY (communityID) REFERENCES communities(communityID)
) engine=innodb;



CREATE TABLE transactions(
     transactionID int NOT NULL AUTO_INCREMENT,
     transactionDate date NOT NULL,
     quantity int NOT NULL,
     status varchar(50),
     materialID int NOT NULL,
     PRIMARY KEY (transactionID),
     FOREIGN KEY (materialID) REFERENCES materials(materialID)
) engine=innodb;


CREATE TABLE user_transaction(
     userID int NOT NULL,
     transactionID int NOT NULL,
     FOREIGN KEY (userID) REFERENCES users(userID),
     FOREIGN KEY (transactionID) REFERENCES transactions(transactionID)
) engine=innodb;

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(255),
    date DATE,
    tags VARCHAR(255),
    description TEXT,
    img VARCHAR(255),
    article_text TEXT
) engine=innodb;

INSERT INTO users (userID, firstName, lastName, email, username, pass, contactNum, user_location, userType)
VALUES
  (1,"Branden","Rich","nulla.vulputate@outlook.net","rbranden","SVR50RYU0KN","(747)579-2386","P.O. Box 858, 7187 Integer Road","individual_user"),
  (2,"Laura","Mann","enim@google.ca","lmann","WPV18GNV4MN","(660)389-8798","Ap #985-7507 Lectus. Avenue","recycler"),
  (3,"Shelley","Love","morbi.tristique@yahoo.edu","slove","OZU75RYK9OU","(574)423-0552","994-8803 Faucibus Avenue","individual_user"),
  (4,"Illana","Wheeler","dapibus.quam.quis@icloud.edu","iwheeler","ICN85EBC3JP","(426)548-1815","P.O. Box 672, 6233 Ante. Ave","individual_user"),
  (5,"Juliet","Mcleod","est@hotmail.com","jmcleod","UNB38WIP5DH","(445)818-5484","124-3288 Sollicitudin St.","recycler"),
  (6,"Erich","Gentry","lorem.ipsum.sodales@outlook.ca","egentry","OOC21PBP6EV","(482)316-3347","Ap #526-5108 Facilisis. St.","recycler"),
  (7,"Micah","Rosales","risus.donec@hotmail.net","yrivera","HVG61QFO7AN","(624)731-4078","Ap #259-4007 Odio Street","recycler"),
  (8,"Yoko","Rivera","libero.mauris@outlook.org","yrivera","VPJ56SKE4TY","(436)152-4706","Ap #904-491 Quisque Avenue","recycler"),
  (9,"Alan","Butler","sed@hotmail.org","abutler","ZDI77INO1TS","(601)883-0795","1691 Curae Ave","manufacturer"),
  (10,"Gabriel","Moody","donec.fringilla.donec@outlook.edu","gmoody","HHB41VYL8HB","(285)187-7761","656-6317 Nisi. Street","individual_user"),
  (11,"Anthony","Hobbs","placerat.velit.quisque@google.org","ahobbs","NRL47EWL5OY","(879)342-5716","684-588 Eget Street","recycler"),
  (12,"Hamish","English","vitae.erat.vel@icloud.net","henglish","NBD27UKW6JI","(341)665-6067","Ap #551-8562 Fusce Ave","manufacturer"),
  (13,"Fitzgerald","Gordon","ultricies@hotmail.com","fgordon","YAA14CEN9XC","(466)782-4882","2043 Ullamcorper Ave","recycler"),
  (14,"Wallace","Bean","vitae@hotmail.ca","wbean","VXW23LPP3SE","(948)681-6175","335-6999 Consequat, Ave","individual_user"),
  (15,"Joy","Gentry","imperdiet.ullamcorper@google.couk","jgentry","IEE63UPS8KD","(516)510-5548","Ap #680-2485 Vel St.","recycler"),
  (16,"Igor","Chen","tortor.nunc.commodo@outlook.net","ichen","YLY05PRE2HP","(744)351-2703","7691 Adipiscing St.","individual_user"),
  (17,"Riley","Pittman","tincidunt.dui.augue@outlook.net","rpittman","ELF30HQA9VF","(828)961-6516","855-840 Dictum Rd.","manufacturer"),
  (18,"Shad","Underwood","sodales.at.velit@aol.org","sunderwood","XYK94XOH3JK","(736)253-4713","Ap #773-7387 Magnis Street","manufacturer"),
  (19,"Nayda","Rodriquez","praesent@google.com","nrodriquez","LOP32FTB3OC","(503)265-2037","396-1225 Donec Ave","manufacturer"),
  (20,"Nadine","Hopper","odio.phasellus@icloud.com","nhopper","GRH47MXV3JN","(256)787-7639","5332 Ultrices Avenue","recycler"),
  (21,"Maggie","Sanchez","orci.ut@icloud.com","msanchez","HBU33ABK5XY","(386)493-9187","P.O. Box 636, 9618 Vitae Rd.","recycler"),
  (22,"Aiko","Douglas","aliquet.magna.a@icloud.org","adouglas","HGX69LCK7GH","(287)914-2946","Ap #814-4525 Pharetra Rd.","recycler"),
  (23,"Anthony","Stevens","sed.pede@aol.ca","astevens","FOB75AKX5UR","(471)377-2276","Ap #548-3698 Donec Road","individual_user"),
  (24,"Keaton","Vincent","lectus@google.ca","kvincent","SQT44HKR6TP","(769)749-5611","P.O. Box 570, 6358 Et Street","recycler"),
  (25,"Kaye","Lawrence","ac.mi@protonmail.com","klawrence","UMW49GIH8MJ","(119)945-3846","P.O. Box 685, 1976 Placerat Av.","recycler");

--Values for local manufacturers --
  (26,"Branden","Rich","nulla.vulputate@outlook.net","rbranden","SVR50RYU0KN","(747)579-2386","P.O. Box 858, 7187 Integer Road","individual_user"),
  (27,"Laura","Mann","enim@google.ca","lmann","WPV18GNV4MN","(660)389-8798","Ap #985-7507 Lectus. Avenue","recycler"),
  (28,"Shelley","Love","morbi.tristique@yahoo.edu","slove","OZU75RYK9OU","(574)423-0552","994-8803 Faucibus Avenue","individual_user"),
  (29,"Illana","Wheeler","dapibus.quam.quis@icloud.edu","iwheeler","ICN85EBC3JP","(426)548-1815","P.O. Box 672, 6233 Ante. Ave","individual_user"),
  (30,"Juliet","Mcleod","est@hotmail.com","jmcleod","UNB38WIP5DH","(445)818-5484","124-3288 Sollicitudin St.","recycler"),
  (31,"Erich","Gentry","lorem.ipsum.sodales@outlook.ca","egentry","OOC21PBP6EV","(482)316-3347","Ap #526-5108 Facilisis. St.","recycler"),
  (32,"Branden","Rich","nulla.vulputate@outlook.net","rbranden","SVR50RYU0KN","(747)579-2386","P.O. Box 858, 7187 Integer Road","individual_user"),
  (33,"Laura","Mann","enim@google.ca","lmann","WPV18GNV4MN","(660)389-8798","Ap #985-7507 Lectus. Avenue","recycler"),
  (34,"Shelley","Love","morbi.tristique@yahoo.edu","slove","OZU75RYK9OU","(574)423-0552","994-8803 Faucibus Avenue","individual_user"),
  (35,"Illana","Wheeler","dapibus.quam.quis@icloud.edu","iwheeler","ICN85EBC3JP","(426)548-1815","P.O. Box 672, 6233 Ante. Ave","individual_user"),
  (36,"Juliet","Mcleod","est@hotmail.com","jmcleod","UNB38WIP5DH","(445)818-5484","124-3288 Sollicitudin St.","recycler");

INSERT INTO recyclers (companyID, companyName, userID)
VALUES
  (1,"Mi Incorporated",1),
  (2,"Purus Ac LLC",2),
  (3,"Mus Proin Vel Ltd",3),
  (4,"Eget Venenatis Ltd",4),
  (5,"Risus Quisque Libero Incorporated",5),
  (6,"Netus Et Corporation",6),
  (7,"Duis Volutpat LLC",7),
  (8,"Leo Elementum PC",8),
  (9,"Consectetuer Adipiscing LLC",9),
  (10,"Vestibulum Lorem PC",10),
  (11,"Vulputate Risus LLC",11),
  (12,"Vestibulum Mauris Industries",12),
  (13,"Diam Inc.",13),
  (14,"Amet PC",14),
  (15,"Parturient Montes Nascetur PC",15),
  (16,"Amet Nulla Donec Institute",16),
  (17,"Cras PC",17),
  (18,"Fermentum Metus Ltd",18),
  (19,"Erat Eget Consulting",19),
  (20,"Metus Facilisis LLP",20),
  (21,"Egestas Aliquam Nec Associates",21),
  (22,"Nunc LLP",22),
  (23,"Sem Consequat PC",23),
  (24,"Ante Vivamus Inc.",24),
  (25,"Iaculis Nec Eleifend Corp.",25);

INSERT INTO recycler_materials (companyID, acceptedMaterial)
VALUES
  (1,"Silk"),
  (2,"Cotton"),
  (8,"Polyester"),
  (3,"Leather"),
  (5,"Cotton"),
  (6,"Wool"),
  (7,"Wool"),
  (8,"Polyester"),
  (4,"Satin"),
  (10,"Cotton"),
  (11,"Linen"),
  (5,"Cotton"),
  (13,"Satin"),
  (1,"Wool"),
  (15,"Linen"),
  (16,"Cotton"),
  (6,"Linen"),
  (18,"Cotton"),
  (19,"Polyester"),
  (20,"Cotton"),
  (21,"Silk"),
  (2,"Leather"),
  (23,"Linen"),
  (1,"Cotton"),
  (25,"Silk");


INSERT INTO manufacturers (manufacturerID, companyName, userID)
VALUES
  (1,"Non Hendrerit Corporation",1),
  (2,"Duis Risus Inc.",2),
  (3,"Tincidunt Tempus Limited",3),
  (4,"Placerat LLP",4),
  (5,"Dolor Fusce Ltd",5),
  (6,"Sed Sem Egestas Associates",6),
  (7,"Arcu Vestibulum Foundation",7),
  (8,"Orci Lacus Vestibulum Ltd",8),
  (9,"Venenatis A Ltd",9),
  (10,"Non Limited",10),
  (11,"Est Ac Foundation",11),
  (12,"Turpis LLP",12),
  (13,"Egestas Hendrerit Associates",13),
  (14,"Pellentesque LLC",14),
  (15,"Diam Associates",15),
  (16,"Sollicitudin Commodo Ipsum Foundation",16),
  (17,"Lacus Associates",17),
  (18,"Faucibus Orci Luctus Corp.",18),
  (19,"Erat Eget PC",19),
  (20,"Ornare Lectus LLC",20),
  (21,"Quisque Industries",21),
  (22,"Vel Institute",22),
  (23,"Gravida Molestie Associates",23),
  (24,"Velit Limited",24),
  (25,"Ante LLC",25);


-- Local Bloomington Residents -- 
INSERT INTO manufacturers (manufacturerID, companyName, cAddress, city, cState, zip, userID)
VALUES
(26, 'Bloomington Iron & Metal Inc', '503 N Rogers St, Bloomington', 'Bloomington', 'Indiana', 47404, 26),
(27, 'Bloomington Recycling Center South', '400 W Dillman Rd, Bloomington', 'Bloomington', 'Indiana', 47403, 27),
(28, 'Ellettsville Recycling Center', '6200 Mathews Dr, Ellettsville', 'Ellettsville', 'Indiana', 47429, 28),
(29, 'Hoosier Disposal', '6660 S Old State Rd 37, Bloomington', 'Bloomington', 'Indiana', 47401, 29),
(30, "JB\'s Salvage, Inc", '1803 Fountain Dr, Bloomington', 'Bloomington', 'Indiana', 47404, 30),
(31, 'MCSWMD - Westside Recycling Center', '341 N Oard Rd, Bloomington', 'Bloomington', 'Indiana', 47404, 31),
(32, 'Monroe County Solid Waste - The District', '3400 S Walnut St, Bloomington', 'Bloomington', 'Indiana', 47401, 32),
(33, 'Northeast Recycling Center', '6015 E State Rd 45, Bloomington', 'Bloomington', 'Indiana', 47408, 33),
(34, 'Republic Services', '6660 IN-37, Bloomington', 'Bloomington', 'Indiana', 47404, 34),
(35, 'Rumpke - Monroe County Resource Recovery Facility', '5220 S Production Dr, Bloomington', 'Bloomington', 'Indiana', 47403, 35),
(36, 'ecoATM', '3313 IN-45, Bloomington', 'Bloomington', 'Indiana', 47408, 36);


INSERT INTO materials (materialID, quantity, materialName, description, manufacturerID)
VALUES
  (1, 752, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 9),
  (2, 436, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 5),
  (3, 67, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 8),
  (4, 840, 'Linen', 'Natural, breathable fabric, crisp and lightweight. Ideal for comfortable, casual elegance in clothing and home textiles.', 15),
  (5, 95, 'Wool', 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.', 15),
  (6, 903, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 24),
  (7, 954, 'Wool', 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.', 5),
  (8, 546, 'Satin', 'Smooth, glossy fabric. Lustrous, luxurious sheen. Often used for elegant, high-quality garments and accessories.', 9),
  (9, 22, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 13),
  (10, 690, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 14),
  (11, 295, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 5),
  (12, 434, 'Wool', 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.', 20),
  (13, 682, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 3),
  (14, 155, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 16),
  (15, 239, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 19),
  (16, 912, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 10),
  (17, 523, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.',  5),
  (18, 365, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 23),
  (19, 990, 'Satin', 'Smooth, glossy fabric. Lustrous, luxurious sheen. Often used for elegant, high-quality garments and accessories.', 25),
  (20, 332, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 13),
  (21, 912, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 19),
  (22, 116, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 14),
  (23, 124, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 3),
  (24, 120, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 18),
  (25, 1, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 20);


INSERT INTO communities (communityID, communityName, communityDescription, communityRules, tags)
VALUES
(1, 'Recycle Right', 'A community dedicated to promoting proper recycling practices and waste management.', 'Follow community guidelines. Respect all members. No spam.', 'waste-management, upcycling, environment'),
(2, 'Sustainability Advocates', 'Join us to advocate for sustainable living and environmental conservation efforts.', 'Follow community guidelines. Respect all members. No spam.', 'environment, green-living, climate-action'),
(3, 'Clean & Green', 'Discover ways to keep our environment clean and green through sustainable practices.', 'Follow community guidelines. Respect all members. No spam.', 'upcycling, sustainability, recycling'),
(4, 'Eco Warriors', 'Be part of a community of eco warriors striving for conservation and eco-friendly living.', 'Follow community guidelines. Respect all members. No spam.', 'conservation, eco-friendly, recycling'),
(5, 'Planet Protectors', 'Join hands to protect our planet through green living and sustainable actions.', 'Follow community guidelines. Respect all members. No spam.', 'green-living, sustainability, eco-friendly'),
(6, 'Green Innovators', 'Innovate towards a greener future with like-minded individuals dedicated to environmental action.', 'Follow community guidelines. Respect all members. No spam.', 'climate-action, environment, conservation'),
(7, 'Eco Heroes', 'Become an eco hero by promoting sustainability, waste management, and eco-friendly practices.', 'Follow community guidelines. Respect all members. No spam.', 'sustainability, waste-management, eco-friendly'),
(8, 'Eco-Friendly Minds', 'Engage with eco-friendly minds to explore recycling, renewable energy, and green living solutions.', 'Follow community guidelines. Respect all members. No spam.', 'recycling, renewable, green-living'),
(9, 'Waste Not', 'Learn how to minimize waste and maximize resources in this community focused on conservation and sustainability.', 'Follow community guidelines. Respect all members. No spam.', 'conservation, sustainability, upcycling'),
(10, 'Green Earth', 'Join us in safeguarding our green earth through eco-friendly practices and renewable initiatives.', 'Follow community guidelines. Respect all members. No spam.', 'eco-friendly, renewable, environment'),
(11, 'Eco Warriors', 'Join forces with eco warriors dedicated to upcycling, recycling, and waste management for a cleaner planet.', 'Follow community guidelines. Respect all members. No spam.', 'upcycling, recycling, waste-management'),
(12, 'Clean & Green', 'Promote sustainability and eco-friendly living in this community committed to a clean and green future.', 'Follow community guidelines. Respect all members. No spam.', 'sustainability, eco-friendly, recycling'),
(13, 'Sustainability Advocates', 'Advocate for green living, environmental protection, and climate action with fellow sustainability advocates.', 'Follow community guidelines. Respect all members. No spam.', 'green-living, environment, climate-action'),
(14, 'Eco Heroes', 'Be a hero for the planet by supporting recycling, renewable energy, and conservation efforts in this community.', 'Follow community guidelines. Respect all members. No spam.', 'recycling, renewable, conservation'),
(15, 'Green Earth', 'Work towards a greener future by focusing on recycling, conservation, and climate action in this community.', 'Follow community guidelines. Respect all members. No spam.', 'recycling, conservation, climate-action'),
(16, 'Eco Warriors', 'Join hands with eco warriors to tackle upcycling, recycling, and waste management challenges.', 'Follow community guidelines. Respect all members. No spam.', 'upcycling, recycling, waste-management'),
(17, 'Eco Warriors', 'Engage with renewable energy enthusiasts and green living advocates in this community.', 'Follow community guidelines. Respect all members. No spam.', 'renewable, upcycling, green-living'),
(18, 'Sustainability Advocates', 'Support waste management, recycling, and conservation efforts in this community of sustainability advocates.', 'Follow community guidelines. Respect all members. No spam.', 'waste-management, recycling, conservation'),
(19, 'Sustainability Advocates', 'Join hands with fellow conservationists and eco-friendly enthusiasts to make a positive impact on the planet.', 'Follow community guidelines. Respect all members. No spam.', 'conservation, eco-friendly, renewable'),
(20, 'Waste Not', 'Fight climate change and promote waste management solutions in this community committed to environmental action.', 'Follow community guidelines. Respect all members. No spam.', 'environment, climate-action, recycling'),
(21, 'Eco-Friendly Minds', 'Connect with like-minded individuals to explore recycling, waste management, and sustainability solutions.', 'Follow community guidelines. Respect all members. No spam.', 'recycling, waste-management, sustainability'),
(22, 'Green Earth', 'Join us to tackle waste management issues and promote renewable energy for a greener earth.', 'Follow community guidelines. Respect all members. No spam.', 'waste-management, renewable, upcycling'),
(23, 'Planet Protectors', 'Protect our planet by embracing upcycling, eco-friendly living, and green lifestyle choices in this community.', 'Follow community guidelines. Respect all members. No spam.', 'upcycling, eco-friendly, green-living'),
(24, 'Waste Not', 'Take action against waste by promoting waste management strategies and eco-friendly practices in this community.', 'Follow community guidelines. Respect all members. No spam.', 'climate-action, waste-management, eco-friendly'),
(25, 'Clean & Green', 'Join hands with sustainability enthusiasts to promote renewable energy, sustainability, and waste management.', 'Follow community guidelines. Respect all members. No spam.', 'renewable, sustainability, waste-management');

  INSERT INTO user_community (userID, communityID) VALUES
  (12, 16),
  (10, 25),
  (10, 4),
  (10, 19),
  (16, 23),
  (4, 13),
  (17, 4),
  (10, 4),
  (14, 6),
  (15, 2),
  (14, 18),
  (4, 4),
  (13, 9),
  (11, 21),
  (7, 23),
  (12, 25),
  (20, 14),
  (14, 24),
  (5, 6),
  (24, 12),
  (13, 9),
  (23, 12),
  (1, 13),
  (6, 21),
  (1, 22);

INSERT INTO transactions (transactionID, transactionDate, quantity, status, materialID) VALUES
  (1, '2023-03-29', 91, 'Pending', 11),
  (2, '2023-11-13', 14, 'Completed', 17),
  (3, '2023-05-30', 74, 'Cancelled', 14),
  (4, '2023-07-07', 65, 'Cancelled', 3),
  (5, '2023-02-05', 12, 'Cancelled', 24),
  (6, '2023-09-20', 87, 'In Progress', 20),
  (7, '2023-07-18', 93, 'Pending', 19),
  (8, '2023-04-14', 46, 'Cancelled', 7),
  (9, '2023-01-04', 48, 'Cancelled', 11),
  (10, '2023-06-21', 72, 'In Progress', 16),
  (11, '2023-02-16', 68, 'Cancelled', 24),
  (12, '2023-12-03', 7, 'Cancelled', 22),
  (13, '2023-10-15', 70, 'In Progress', 2),
  (14, '2023-06-29', 90, 'Cancelled', 24),
  (15, '2023-11-25', 32, 'Completed', 17),
  (16, '2023-01-17', 17, 'In Progress', 7),
  (17, '2023-06-04', 97, 'In Progress', 22),
  (18, '2023-02-13', 11, 'Cancelled', 21),
  (19, '2023-01-10', 97, 'Pending', 11),
  (20, '2023-03-25', 43, 'Cancelled', 23),
  (21, '2023-12-01', 47, 'In Progress', 9),
  (22, '2023-02-02', 95, 'Completed', 3),
  (23, '2023-11-14', 73, 'Pending', 14),
  (24, '2023-08-08', 39, 'In Progress', 19),
  (25, '2023-06-16', 89, 'Cancelled', 24);

INSERT INTO user_transaction (userID, transactionID) VALUES
  (19, 3),
  (13, 13),
  (4, 5),
  (15, 21),
  (9, 7),
  (24, 22),
  (15, 4),
  (16, 21),
  (7, 10),
  (25, 25),
  (18, 12),
  (6, 6),
  (5, 16),
  (15, 11),
  (6, 20),
  (24, 19),
  (2, 7),
  (13, 9),
  (7, 6),
  (2, 17),
  (14, 11),
  (7, 3),
  (13, 2),
  (10, 20),
  (18, 2);

INSERT INTO articles (title, author, date, tags, description, img, article_text) VALUES
("10 Tips for Sustainable Shopping", "Alex Green", "2024-02-01", "sustainable,shopping", 
"Here are 10 essential tips for shopping sustainably, including looking for eco-friendly materials and considering the longevity of your clothes.", "img/10_tips_for_sustainable_shopping.jpeg",
"Shopping sustainably is essential for reducing our environmental footprint and making more ethical choices. Here are ten tips to help you shop more sustainably:\n\n**1. Opt for Eco-Friendly Materials**: Look for clothes made from organic cotton, bamboo, or recycled materials.\n\n**2. Quality Over Quantity**: Invest in high-quality items that will last longer, reducing the need to buy new clothes frequently.\n\n**3. Support Ethical Brands**: Choose brands that are transparent about their manufacturing processes and are committed to ethical practices.\n\n**4. Think Second-Hand**: Before buying new, consider if an item can be found second-hand. This reduces demand for new products and supports recycling.\n\n**5. Recycle and Donate**: Instead of throwing away old clothes, recycle them or donate to charity shops.\n\n**6. Repair and Upcycle**: Learn basic sewing skills to repair or upcycle your clothes, extending their life and reducing waste.\n\n**7. Avoid Fast Fashion Trends**: Invest in timeless pieces rather than following fast fashion trends that go out of style quickly.\n\n**8. Use Eco-Friendly Laundry Practices**: Wash clothes less frequently, use cold water, and eco-friendly detergents to reduce environmental impact.\n\n**9. Educate Yourself**: Stay informed about the environmental impact of the fashion industry and how your shopping habits can make a difference.\n\n**10. Spread the Word**: Encourage friends and family to adopt more sustainable shopping practices.\n\nBy following these tips, we can all make a difference in promoting sustainable fashion and reducing waste."),
("The Truth About Fast Fashion", "Jamie Sun", "2024-02-05", "fast fashion,recycling",
"Discover the impact of fast fashion on the environment and learn what you can do to make a difference.", "img/the_truth_about_fast_fashion.jpeg",
"Fast fashion has revolutionized how we buy clothes, offering the latest trends at low prices. However, this convenience comes at a significant environmental cost. Each year, the fast fashion industry contributes massively to landfill waste, water pollution, and carbon emissions, making it one of the largest polluters globally.\n\n**Environmental Impact**:\n\n__1. Waste Production__: The fast fashion industry is notorious for creating an enormous amount of textile waste. Millions of tons of unsold or worn clothing end up in landfills annually, where they take decades to decompose.\n\n__2. Water Pollution__: The dyeing and treatment processes of textiles release toxic chemicals into water bodies, severely affecting aquatic life and the health of communities living nearby.\n\n__3. Carbon Emissions__: The production and transportation of fast fashion items generate significant carbon emissions, contributing to global warming and climate change.\n\n**Making a Difference**:\n\n__1. Support Sustainable Brands__: Look for companies that prioritize sustainability in their manufacturing processes and use eco-friendly materials.\n\n__2. Quality Over Quantity__: Opt for purchasing fewer, higher-quality items that last longer, reducing the demand for fast fashion.\n\n__3. Recycle and Upcycle__: Engage in recycling and upcycling old clothes instead of discarding them. This can significantly reduce waste and promote a more sustainable fashion cycle.\n\n__4. Educate Yourself and Others__: Stay informed about the environmental impact of your fashion choices and encourage others to rethink their shopping habits.\n\nBy understanding the truth about fast fashion and taking actionable steps towards sustainability, we can all contribute to a healthier planet. The choices we make today can lead to a more sustainable and ethical fashion industry tomorrow."),
("Thrifting: The Ultimate Guide", "Casey Moon", "2024-02-10", "thrifting,sustainable", 
"Thrifting isn't just a trend; it's a way of life. Find out how to thrift effectively and sustainably.", "img/thrifting_the_ultimate_guide.jpeg",
"Thrifting has emerged as a powerful tool in the fight against fast fashion, offering a sustainable alternative that benefits both the planet and your wallet. This guide will take you through the essentials of thrifting, from finding the best deals to making your thrifted finds last longer.\n\n**Why Thrift?**\n\n__1. Environmental Impact__: Thrifting reduces waste by giving new life to pre-owned items, decreasing the demand for new clothing production.\n\n__2. Economic Benefits__: It offers the opportunity to save money while discovering unique items that aren't available in mainstream stores.\n\n__3. Support for Local Communities__: Many thrift stores are charitable organizations that support local community projects.\n\n**Effective Thrifting Tips**:\n\n__1. Know What You're Looking For__: Have a list of needed items to avoid impulse buys. This makes your thrifting more purposeful and efficient.\n\n__2. Check Items Thoroughly__: Look for any damages or stains that might be hard to remove. It's important to select items that are in good condition.\n\n__3. Research Thrift Stores__: Some stores specialize in certain types of items or have better quality selections. Researching can lead you to the best shops.\n\n__4. Learn the Best Times to Shop__: Many thrift stores restock on specific days. Knowing these can give you first pick on new arrivals.\n\n__5. Be Patient__: Thrifting requires patience as it might take time to find the perfect item. Enjoy the hunt as part of the experience.\n\n**Sustainable Thrifting Practices**:\n\n__1. Donate as You Buy__: Keep the cycle going by donating items you no longer need, making room for your new thrifted finds.\n\n__2. Upcycle and Repair__: Get creative by upcycling or repairing items to fit your style or needs, further extending the life of your thrifted goods.\n\n__3. Spread the Word__: Encourage friends and family to consider thrifting by sharing your finds and experiences.\n\nThrifting is more than just shopping; it's a lifestyle choice that promotes sustainability, supports local communities, and offers a unique and personal way to express fashion. By adopting thoughtful thrifting habits, we can make a significant impact on reducing waste and promoting a more sustainable world."),
("How to Recycle Clothes Properly", "Morgan Sky", "2024-02-15", "recycling,clothes", 
"Learn the ins and outs of recycling clothes, from what can be recycled to where to take your old garments.", "img/how_to_recycle_clothes_properly.jpeg",
"Recycling clothes is a crucial step in reducing waste and supporting sustainable fashion. However, knowing how to recycle clothes properly can be challenging. This guide provides essential tips on what can be recycled, how to prepare your clothes for recycling, and where to take them.\n\n**What Can Be Recycled?**\n\n__1. Textile Recycling__: Most textiles can be recycled, including cotton, linen, wool, and synthetic fabrics. Even worn-out or damaged clothing can be recycled into new materials.\n\n__2. Footwear__: Shoes and sneakers can often be recycled, provided they are clean and in pairs.\n\n**Preparing Clothes for Recycling**:\n\n__1. Clean Your Clothes__: Ensure that all items are clean and dry. Dirty or wet clothing can contaminate other recyclables and may not be accepted.\n\n__2. Sort by Material__: Some recycling programs require textiles to be sorted by material type. Check with your local recycling guidelines.\n\n**Where to Recycle Clothes**:\n\n__1. Textile Recycling Bins__: Many communities have textile recycling bins where you can drop off your unwanted clothes. These are often located in convenient locations like supermarkets or community centers.\n\n__2. Charity Shops and Donation Centers__: Some charities accept clothes for resale or donation to those in need. Check which items are accepted beforehand.\n\n__3. Specialized Recycling Programs__: Some brands and organizations offer take-back programs or specialized recycling options for clothing and footwear.\n\n**Other Ways to Recycle**:\n\n__1. Upcycling__: Transform old clothes into new items, such as bags, quilts, or even new garments.\n\n__2. Clothing Swaps__: Participate in or organize a clothing swap with friends or community members to give clothes a new life.\n\n__3. Selling__: Sell wearable items through second-hand stores or online platforms to extend their lifespan.\n\nRecycling clothes not only helps reduce waste but also conserves resources and supports a more sustainable fashion industry. By following these guidelines, you can make a significant impact on the environment and contribute to a circular fashion economy."),
("Eco-Friendly Fabrics 101", "Taylor River", "2024-02-20", "eco-friendly,fabrics", 
"Explore the world of eco-friendly fabrics and how choosing the right materials can make a huge difference.", "img/ecofriendly_fabrics_101.jpeg",
"As the fashion industry moves towards more sustainable practices, the choice of fabric has become crucial. Eco-friendly fabrics not only minimize environmental impact but also offer benefits such as biodegradability and reduced toxicity. This guide introduces you to several eco-friendly fabrics, their benefits, and why they're essential for a sustainable future.\n\n**Organic Cotton**: Unlike conventional cotton, organic cotton is grown without the use of harmful pesticides or synthetic fertilizers, making it a more sustainable choice. It requires less water and promotes healthier soil conditions.\n\n**Bamboo**: Bamboo fabric is made from the pulp of bamboo grass. It's praised for its rapid growth and ability to regenerate without needing pesticides. Bamboo fabric is soft, breathable, and biodegradable.\n\n**Hemp**: Hemp is a highly sustainable crop that grows quickly, doesn't require pesticides, and uses far less water than traditional crops. Hemp fabric is durable, absorbent, and becomes softer with each wash.\n\n**Recycled Polyester**: Made by recycling existing plastic products, such as PET bottles, recycled polyester reduces dependence on petroleum as a source of raw materials and emits fewer greenhouse gases compared to its virgin counterpart.\n\n**Tencel (Lyocell)**: Tencel is made from the wood pulp of trees grown on sustainably managed plantations. Its production process is closed-loop, meaning almost all the chemicals and solvents used in processing Tencel are recovered and reused.\n\n**Linen**: Produced from the flax plant, linen is another highly sustainable fabric. It doesn't require much water or pesticides to grow and is completely biodegradable. Linen is lightweight, breathable, and known for its natural luster.\n\n**Choosing Eco-Friendly Fabrics**:\n\n__1. Research__: Learn about where and how the fabrics are produced. Transparency from brands about their supply chain is crucial.\n\n__2. Consider the Lifecycle__: Think about the durability and care requirements of eco-friendly fabrics. Opting for materials that last longer and require less energy to maintain can further reduce your environmental footprint.\n\n__3. Support Sustainable Brands__: Choose brands that are committed to sustainable practices and ethical production methods.\n\nBy incorporating eco-friendly fabrics into our wardrobes, we can significantly reduce the environmental impact of our clothing choices. As consumers, making informed decisions about the materials we wear can lead to a more sustainable and responsible fashion industry."),
("The Benefits of Slow Fashion", "Jordan Stone", "2024-02-25", "slow fashion,sustainable", 
"Slow fashion isn't just a concept; it's a movement. Understand its benefits and how you can participate.", "img/the_benefits_of_slow_fashion.jpeg",
"Slow fashion is a response to the fast-paced changes in the fashion industry, focusing on sustainability, ethics, and quality. It encourages consumers to be more mindful about their clothing choices, emphasizing the importance of purchasing fewer, but higher-quality items that last longer. Here are the key benefits of slow fashion and how you can be a part of this positive change.\n\n**Benefits of Slow Fashion**:\n\n__1. Environmental Sustainability__: Slow fashion reduces waste and pollution since it focuses on durable materials and timeless designs that outlast trends. By producing and consuming less, the slow fashion movement significantly lowers its environmental footprint.\n\n__2. Ethical Manufacturing__: This approach often involves fair labor practices and the use of ethically sourced materials. It supports communities and ensures that workers in the fashion industry are treated fairly and work in safe conditions.\n\n__3. Quality over Quantity__: Slow fashion brands prioritize craftsmanship and quality, offering pieces that are built to last. This not only means better products for consumers but also less frequent purchases, reducing the overall demand for new clothing.\n\n__4. Personal Style__: Slow fashion encourages consumers to develop their unique style rather than chasing fast-changing trends. This leads to more meaningful purchases and a more personalized wardrobe.\n\n__5. Cost-Effectiveness__: While slow fashion items might have a higher upfront cost, their durability and timeless design ensure that they remain wearable for years, offering better value over time compared to fast fashion alternatives.\n\n**How to Participate in Slow Fashion**:\n\n__1. Educate Yourself__: Learn about the brands you support and their manufacturing processes. Look for companies that prioritize sustainability and ethical practices.\n\n__2. Invest in Quality__: Choose quality over quantity by selecting well-made items that will last for years, not just a season.\n\n__3. Buy Less__: Reduce your consumption by only buying what you truly need and will wear regularly.\n\n__4. Care for Your Clothes__: Properly caring for your garments can extend their life significantly. Follow washing instructions, repair damages, and store items correctly.\n\n__5. Support Ethical Brands__: Seek out and support brands that align with slow fashion principles. By doing so, you contribute to a demand for responsible fashion.\n\nBy embracing slow fashion, we can all contribute to a more sustainable and ethical world. It's a choice that benefits not only the environment and workers but also enriches our own lives with more thoughtful and meaningful consumption."),
("DIY Upcycling Clothing Projects", "Riley Blue", "2024-03-01", "upcycling,DIY", 
"Get creative with these DIY upcycling projects for your old clothes. Turn something old into something new and stylish.", "img/diy_upcycling_clothing_projects.jpeg",
"Breathing new life into old clothes not only saves them from the landfill but also gives you a unique style that's all your own. Here are some creative DIY upcycling projects that can transform your wardrobe without breaking the bank.\n\n**1. T-Shirt Tote Bag**:\nTurn your old t-shirts into handy tote bags. Cut off the sleeves and neckline, stitch the bottom closed, and you have a perfect bag for groceries or beach outings.\n\n**2. Denim Jean Planters**:\nGive your plants a stylish home by using the legs of old jeans. Cut the legs, fill them with soil, and hang them up as vertical planters. It's a fun way to add a quirky touch to your decor.\n\n**3. Scarf Kimono**:\nTransform a large scarf or lightweight fabric into a chic kimono. With minimal sewing, you can create an elegant cover-up, perfect for summer evenings.\n\n**4. Patchwork Blanket**:\nCombine various fabric scraps or old clothes into a beautiful patchwork blanket. This project can be a sentimental journey, turning pieces of clothing with memories into something cozy and new.\n\n**5. Embroidered Jeans**:\nAdd a personal touch to your jeans by embroidering designs on them. Whether it's a simple pattern along the pockets or a detailed design on the legs, embroidery can elevate the look of your denim.\n\n**6. Button-Down Skirt**:\nTransform an oversized button-down shirt into a stylish skirt. With some cutting and sewing, the shirt's bottom can become the waistband of a new skirt, complete with button details.\n\n**7. Sweater Pillow Covers**:\nOld sweaters can make cozy and decorative pillow covers. Simply cut the sweater to size, sew it into a pillow shape, and insert a pillow form or stuffing.\n\n**8. Fabric Jewelry**:\nCreate unique jewelry pieces by braiding or knotting fabric scraps. This can be a great way to make matching accessories for your upcycled outfits.\n\nThese DIY projects are just the beginning. With a little creativity and some basic sewing skills, you can upcycle almost any old piece of clothing into something new and fashionable. Upcycling not only promotes sustainability but also allows you to express your individual style in an eco-friendly way."),
("Why You Should Consider Second-Hand", "Charlie Forest", "2024-03-05", "second-hand,thrifting", 
"Second-hand shopping can be a treasure trove. Discover the benefits of buying used clothes.", "img/why_you_should_consider_secondhand.jpeg",
"Second-hand shopping is not just a way to save money; it's a lifestyle choice that benefits the environment, supports your local economy, and allows for a unique personal style. Here are some compelling reasons why you should consider adding second-hand finds to your wardrobe:\n\n**1. Environmental Impact**: Buying second-hand clothes significantly reduces your carbon footprint. It saves garments from ending up in landfills and reduces the demand for new clothing production, which is often resource-intensive and polluting.\n\n**2. Cost-Effective**: Second-hand items are typically much cheaper than their brand-new counterparts, allowing you to stretch your budget further. This affordability makes it easier to invest in higher-quality pieces that would otherwise be out of reach.\n\n**3. Unique Finds**: Thrift stores, vintage shops, and online second-hand platforms are treasure troves of unique items. Shopping second-hand means you're less likely to wear the same outfit as someone else, giving you the opportunity to curate a distinctive wardrobe.\n\n**4. Quality and Craftsmanship**: Many older items were made with a focus on quality and durability, which is often lacking in today's fast fashion. By choosing second-hand, you can enjoy superior craftsmanship at a fraction of the cost.\n\n**5. Ethical Consumption**: Second-hand shopping is a step away from the fast fashion industry, known for its questionable labor practices and environmental disregard. By opting for used clothes, you're supporting a more sustainable and ethical way of consuming fashion.\n\n**6. Supporting Local Businesses**: When you shop at local thrift stores or charity shops, you're supporting local businesses and non-profits. This not only benefits your local economy but also contributes to community development.\n\n**7. Discovering Vintage Trends**: Vintage clothing allows you to explore different eras and trends, adding depth and history to your wardrobe. These pieces can become the cornerstone of your personal style.\n\nEmbracing second-hand shopping is a rewarding experience that offers numerous benefits beyond mere cost savings. It's about making conscious choices that align with sustainable living, ethical consumerism, and the pursuit of individuality. Next time you consider updating your wardrobe, remember that second-hand shops might just have exactly what you're looking for."),
("Sustainable Fashion Brands to Watch", "Jordan Sage", "2024-03-10", "sustainable,brands", 
"Highlighting sustainable fashion brands that are making a difference in the industry.", "img/sustainable_fashion_brands_to_watch.jpeg",
"The fashion industry is undergoing a transformation, with an increasing number of brands committing to sustainable and ethical practices. From using eco-friendly materials to ensuring fair labor conditions, these brands are setting new standards for the industry. Here are some sustainable fashion brands that deserve your attention:\n\n**1. Patagonia**: Known for its commitment to the environment, Patagonia uses recycled materials and organic cotton in its products and takes a stand on environmental issues.\n\n**2. Reformation**: This brand focuses on minimizing its environmental impact by using sustainable materials and methods in its clothing production, and it provides detailed information about its carbon footprint.\n\n**3. Stella McCartney**: A pioneer in sustainable luxury fashion, Stella McCartney's brand is committed to being entirely cruelty-free and uses innovative eco-friendly materials across its collections.\n\n**4. Eileen Fisher**: With a focus on simplicity and sustainability, Eileen Fisher offers clothing made from organic and recycled materials, and the company is known for its ethical business practices.\n\n**5. Veja**: Specializing in sneakers, Veja uses sustainable materials like wild rubber, organic cotton, and recycled plastic bottles to make stylish and durable footwear.\n\n**6. Everlane**: Everlane emphasizes transparency in its pricing and production, offering high-quality basics made in ethical factories and with sustainable materials.\n\n**7. People Tree**: As a pioneer in ethical and sustainable fashion, People Tree partners with Fair Trade producers, garment workers, artisans, and farmers in the developing world to produce eco-friendly and ethical clothing.\n\n**8. Kotn**: Focused on quality and transparency, Kotn sources its materials directly from farmers and sets up initiatives to give back to those communities, ensuring fair labor practices and sustainability.\n\nThese brands are just a few examples of how the fashion industry can move towards a more sustainable future. By supporting these and other sustainable fashion brands, consumers can help drive positive change, promoting environmental stewardship, social responsibility, and ethical business practices in one of the world's most influential industries."),
("The Impact of Your Wardrobe Choices", "Alexa Dawn", "2024-03-15", "impact,wardrobe", 
"Every choice in your wardrobe has an impact. Learn how to make choices that are better for the planet.", "img/the_impact_of_your_wardrobe_choices.jpeg",
"The clothes we choose to buy and wear have far-reaching effects on our planet, from the water used in their production to the waste created when they're no longer wanted. Making conscious wardrobe choices can significantly reduce our environmental footprint. Here's how to make choices that are better for the planet:\n\n**1. Opt for Quality Over Quantity**: Investing in high-quality garments that last longer means you'll buy less over time, reducing waste and consumption.\n\n**2. Choose Sustainable Fabrics**: Look for clothing made from eco-friendly materials such as organic cotton, hemp, bamboo, or recycled fabrics. These materials have a lower environmental impact compared to conventional ones.\n\n**3. Support Ethical Brands**: Choose brands that are transparent about their manufacturing processes and committed to ethical practices, ensuring workers are treated fairly and environmental standards are met.\n\n**4. Embrace Second-Hand and Vintage**: Buying second-hand or vintage clothing not only saves pieces from ending up in landfill but also reduces the demand for new clothing production.\n\n**5. Care for Your Clothes**: Properly caring for your garments (washing in cold water, air drying, repairing instead of discarding) can extend their life, significantly reducing their environmental impact.\n\n**6. Recycle or Donate Unwanted Items**: Instead of throwing away clothes, consider donating them to charity or recycling them through textile recycling programs.\n\n**7. Educate Yourself and Others**: Stay informed about the impact of the fashion industry on the environment and share this knowledge with friends and family to encourage more sustainable habits.\n\n**8. Reduce, Reuse, Upcycle**: Before buying new, see if you can reuse or upcycle items you already own to meet your needs, reducing the need for new resources.\n\nEvery action counts, and by making informed, conscious decisions about our wardrobe choices, we can all contribute to a more sustainable and ethical fashion industry. It's not just about the clothes we wear but the legacy we leave behind for future generations.");