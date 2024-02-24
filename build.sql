drop table if exists posts;
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
    pass varchar(250),
    contactNum VARCHAR(13),
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
    country varchar(50),
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
     recyclerID int NOT NULL,
     FOREIGN KEY (userID) REFERENCES users(userID),
     FOREIGN KEY (transactionID) REFERENCES transactions(transactionID),
     foreign key (recyclerID) REFERENCES recyclers(companyID)
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


CREATE TABLE posts (
  postID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  title varchar(250),
  content varchar(250),
  like_count INT,
  userID INT NOT NULL,
  communityID INT NOT NULL,
  FOREIGN KEY (userID) references users(userID),
  FOREIGN KEY (communityID) references communities(communityID)
);


--individual users -- 
INSERT INTO users (userID, firstName, lastName, email, username, pass, contactNum, userType)
VALUES
  (1, "Branden", "Rich", "nulla.vulputate@outlook.net", "rbranden", "SVR50RYU0KN", "(747)579-2386", "individual_user"),
  (2, "Laura", "Mann", "enim@google.ca", "lmann", "WPV18GNV4MN", "(660)389-8798", "individual_user"),
  (3, "Shelley", "Love", "morbi.tristique@yahoo.edu", "slove", "OZU75RYK9OU", "(574)423-0552", "individual_user"),
  (4, "Illana", "Wheeler", "dapibus.quam.quis@icloud.edu", "iwheeler", "ICN85EBC3JP", "(426)548-1815", "individual_user"),
  (5, "Juliet", "Mcleod", "est@hotmail.com", "jmcleod", "UNB38WIP5DH", "(445)818-5484", "individual_user"),
  (6, "Erich", "Gentry", "lorem.ipsum.sodales@outlook.ca", "egentry", "OOC21PBP6EV", "(482)316-3347", "individual_user"),
  (7, "Micah", "Rosales", "risus.donec@hotmail.net", "yrivera", "HVG61QFO7AN", "(624)731-4078", "individual_user"),
  (8, "Yoko", "Rivera", "libero.mauris@outlook.org", "yrivera", "VPJ56SKE4TY", "(436)152-4706", "individual_user"),
  (9, "Alan", "Butler", "sed@hotmail.org", "abutler", "ZDI77INO1TS", "(601)883-0795", "individual_user"),
  (10, "Gabriel", "Moody", "donec.fringilla.donec@outlook.edu", "gmoody", "HHB41VYL8HB", "(285)187-7761", "individual_user"),
  (11, "Anthony", "Hobbs", "placerat.velit.quisque@google.org", "ahobbs", "NRL47EWL5OY", "(879)342-5716", "individual_user"),
  (12, "Hamish", "English", "vitae.erat.vel@icloud.net", "henglish", "NBD27UKW6JI", "(341)665-6067", "individual_user"),
  (13, "Fitzgerald", "Gordon", "ultricies@hotmail.com", "fgordon", "YAA14CEN9XC", "(466)782-4882", "individual_user"),
  (14, "Wallace", "Bean", "vitae@hotmail.ca", "wbean", "VXW23LPP3SE", "(948)681-6175", "individual_user"),
  (15, "Joy", "Gentry", "imperdiet.ullamcorper@google.couk", "jgentry", "IEE63UPS8KD", "(516)510-5548", "individual_user"),
  (16, "Igor", "Chen", "tortor.nunc.commodo@outlook.net", "ichen", "YLY05PRE2HP", "(744)351-2703", "individual_user"),
  (17, "Riley", "Pittman", "tincidunt.dui.augue@outlook.net", "rpittman", "ELF30HQA9VF", "(828)961-6516", "individual_user"),
  (18, "Shad", "Underwood", "sodales.at.velit@aol.org", "sunderwood", "XYK94XOH3JK", "(736)253-4713", "individual_user"),
  (19, "Nayda", "Rodriquez", "praesent@google.com", "nrodriquez", "LOP32FTB3OC", "(503)265-2037", "individual_user"),
  (20, "Nadine", "Hopper", "odio.phasellus@icloud.com", "nhopper", "GRH47MXV3JN", "(256)787-7639", "individual_user"),
  (21, "Maggie", "Sanchez", "orci.ut@icloud.com", "msanchez", "HBU33ABK5XY", "(386)493-9187", "individual_user"),
  (22, "Aiko", "Douglas", "aliquet.magna.a@icloud.org", "adouglas", "HGX69LCK7GH", "(287)914-2946", "individual_user"),
  (23, "Anthony", "Stevens", "sed.pede@aol.ca", "astevens", "FOB75AKX5UR", "(471)377-2276", "individual_user"),
  (24, "Keaton", "Vincent", "lectus@google.ca", "kvincent", "SQT44HKR6TP", "(769)749-5611", "individual_user"),
  (25, "Kaye", "Lawrence", "ac.mi@protonmail.com", "klawrence", "UMW49GIH8MJ", "(119)945-3846", "individual_user");

--userID for local recyclers --
INSERT INTO users (userID, firstName, lastName, email, username, pass, contactNum, usertype)
VALUES
  (26, 'John', 'Doe', 'john.doe@example.com', 'johndoe', 'FDJASLFJKLA', '(123)456-7890', 'recycler'),
  (27, 'Alice', 'Smith', 'alice.smith@example.com', 'alicesmith', 'HFDASFJKAL', '(987)654-3210', 'recycler'),
  (28, 'Bob', 'Johnson', 'bob.johnson@example.com', 'bobjohnson', 'FDSAJLVDAS', '(555)123-4567', 'recycler'),
  (29, 'Emma', 'Davis', 'emma.davis@example.com', 'emmadavis', 'JFDASLADSL', '(111)222-3333', 'recycler'),
  (30, 'Charlie', 'Miller', 'charlie.miller@example.com', 'charliemiller', 'DJAKLVDSAVD', '(999)888-7777', 'recycler'),
  (31, 'Eva', 'Clark', 'eva.clark@example.com', 'evaclark', 'DASVDAFDSA', '(777)666-5555', 'recycler'),
  (32, 'David', 'Johnson', 'david.johnson@example.com', 'davidjohnson', 'VJKCVUE', '(555)123-4567', 'recycler'),
  (33, 'Sophie', 'Miller', 'sophie.miller@example.com', 'sophiemiller', 'JVLDSAEIRO', '(999)888-7777', 'recycler'),
  (34, 'Adam', 'Clark', 'adam.clark@example.com', 'adamclark', 'VDASJCM', '(777)666-5555', 'recycler'),
  (35, 'Olivia', 'Davis', 'olivia.davis@example.com', 'oliviadavis', 'FDASJKLVDSA', '(111)222-3333', 'recycler'),
  (36, 'Noah', 'Smith', 'noah.smith@example.com', 'noahsmith', 'FDSAJLDVSAJL', '(987)654-3210', 'recycler');

--userID for manufacturers --

INSERT INTO users (userID, firstName, lastName, email, username, pass, contactNum, usertype)
VALUES
(37, 'John', 'Doe', 'john.doe@example.com', 'john_doe_manufacturer', 'ADVLKVDSALJK', '(123)456-7890', 'manufacturer'),
(38, 'Jane', 'Smith', 'jane.smith@example.com', 'jane_smith_manufacturer', 'DAJVAKLSVJDKALS', '(987)654-3210', 'manufacturer'),
(39, 'Bob', 'Johnson', 'bob.johnson@example.com', 'bob_johnson_manufacturer', 'DFSAJVU9OEO', '(555)123-4567', 'manufacturer'),
(40, 'Alice', 'Williams', 'alice.williams@example.com', 'alice_williams_manufacturer', 'CVJKOUEIOR', '(123)987-6543', 'manufacturer'),
(41, 'Charlie', 'Brown', 'charlie.brown@example.com', 'charlie_brown_manufacturer', 'CXVNMCIERSO', '(555)567-8901', 'manufacturer'),
(42, 'Eva', 'Davis', 'eva.davis@example.com', 'eva_davis_manufacturer', 'FDASLVASJKLJ', '(123)456-7890', 'manufacturer'),
(43, 'Frank', 'Evans', 'frank.evans@example.com', 'frank_evans_manufacturer', 'FDJLAKLAFJKLDSA', '(555)123-4567', 'manufacturer'),
(44, 'Grace', 'Hall', 'grace.hall@example.com', 'grace_hall_manufacturer', 'FDJSAKLVCJAKL', '(123)987-6543', 'manufacturer'),
(45, 'Henry', 'Irwin', 'henry.irwin@example.com', 'henry_irwin_manufacturer', 'CMNVERUUIUFO', '(555)567-8901', 'manufacturer'),
(46, 'Ivy', 'Jones', 'ivy.jones@example.com', 'ivy_jones_manufacturer', 'CXMVKLJDEI', '(123)456-7890', 'manufacturer');


-- recyclers -- 
INSERT INTO recyclers (companyID, companyName, cAddress, city, cState, zip, userID, country)
VALUES
(1, 'Bloomington Iron & Metal Inc', '503 N Rogers St', 'Bloomington', 'IN', 47404, 26, 'United States'),
(2, 'Bloomington Recycling Center South', '400 W Dillman Rd', 'Bloomington', 'IN', 47403, 27, 'United States'),
(3, 'Ellettsville Recycling Center', '6200 Mathews Dr', 'Ellettsville', 'IN', 47429, 28, 'United States'),
(4, 'Hoosier Disposal', '6660 S Old State Rd 37', 'Bloomington', 'IN', 47401, 29, 'United States'),
(5, "JB\'s Salvage, Inc", '1803 Fountain Dr', 'Bloomington', 'IN', 47404, 30, 'United States'),
(6, 'MCSWMD - Westside Recycling Center', '341 N Oard Rd', 'Bloomington', 'IN', 47404, 31, 'United States'),
(7, 'Monroe County Solid Waste - The District', '3400 S Walnut St', 'Bloomington', 'IN', 47401, 32, 'United States'),
(8, 'Northeast Recycling Center', '6015 E State Rd 45', 'Bloomington', 'IN', 47408, 33, 'United States'),
(9, 'Republic Services', '6660 IN-37', 'Bloomington', 'IN', 47404, 34, 'United States'),
(10, 'Rumpke - Monroe County Resource Recovery Facility', '5220 S Production Dr', 'Bloomington', 'IN', 47403, 35, 'United States'),
(11, 'ecoATM', '3313 IN-45', 'Bloomington', 'IN', 47408, 36, 'United States');


INSERT INTO recycler_materials (companyID, acceptedMaterial)
VALUES
  (1,"Silk"),
  (2,"Cotton"),
  (3,"Polyester"),
  (3,"Leather"),
  (5,"Cotton"),
  (6,"Wool"),
  (7,"Wool"),
  (8,"Polyester"),
  (4,"Satin"),
  (10,"Cotton"),
  (11,"Linen"),
  (5,"Cotton"),
  (3,"Satin"),
  (1,"Wool"),
  (5,"Linen"),
  (6,"Cotton"),
  (6,"Linen"),
  (8,"Cotton"),
  (9,"Polyester"),
  (2,"Cotton"),
  (1,"Silk"),
  (8,"Leather"),
  (3,"Linen"),
  (1,"Cotton"),
  (5,"Silk");


--mock manufacturer values that correspond with users table -- 
INSERT INTO manufacturers (manufacturerID, companyName, cAddress, city, cState, zip, userID)
VALUES
(1, 'ThreadStyle Boutique', '123 Main St, Bloomington', 'Bloomington', 'Indiana', 47401, 37),
(2, 'VelvetVogue Creations', '456 Oak St, Ellettsville', 'Ellettsville', 'Indiana', 47429, 38),
(3, 'UrbanChic Apparel', '789 Pine St, Bloomington', 'Bloomington', 'Indiana', 47403, 39),
(4, 'DenimDreams Workshop', '101 Elm St, Bloomington', 'Bloomington', 'Indiana', 47404, 40),
(5, 'EcoFashion Emporium', '202 Maple St, Ellettsville', 'Ellettsville', 'Indiana', 47404, 41),
(6, 'SleekSilhouette Studios', '303 Cedar St, Bloomington', 'Bloomington', 'Indiana', 47401, 42),
(7, 'BirchBoutique & Co.', '404 Birch St, Bloomington', 'Bloomington', 'Indiana', 47404, 43),
(8, 'RedwoodRunway Creations', '505 Redwood St, Bloomington', 'Bloomington', 'Indiana', 47408, 44),
(9, 'SpruceStyle Collections', '606 Spruce St, Bloomington', 'Bloomington', 'Indiana', 47401, 45),
(10, 'WalnutWardrobe Workshop', '707 Walnut St, Bloomington', 'Bloomington', 'Indiana', 47404, 46)
;


INSERT INTO materials (materialID, quantity, materialName, description, manufacturerID)
VALUES
  (1, 752, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 9),
  (2, 436, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 5),
  (3, 67, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 8),
  (4, 840, 'Linen', 'Natural, breathable fabric, crisp and lightweight. Ideal for comfortable, casual elegance in clothing and home textiles.', 1),
  (5, 95, 'Wool', 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.', 5),
  (6, 903, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 4),
  (7, 954, 'Wool', 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.', 5),
  (8, 546, 'Satin', 'Smooth, glossy fabric. Lustrous, luxurious sheen. Often used for elegant, high-quality garments and accessories.', 9),
  (9, 22, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 3),
  (10, 690, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 4),
  (11, 295, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 5),
  (12, 434, 'Wool', 'Warm, insulating fiber from sheep. Cozy, versatile material for clothing and textiles.', 2),
  (13, 682, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 3),
  (14, 155, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 6),
  (15, 239, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 9),
  (16, 912, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 1),
  (17, 523, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.',  5),
  (18, 365, 'Polyester', 'Synthetic, durable fabric. Wrinkle-resistant, quick-drying, and widely used for clothing and home furnishings.', 3),
  (19, 990, 'Satin', 'Smooth, glossy fabric. Lustrous, luxurious sheen. Often used for elegant, high-quality garments and accessories.', 5),
  (20, 332, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 3),
  (21, 912, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 9),
  (22, 116, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 4),
  (23, 124, 'Cotton', 'Natural, soft, breathable fabric from cotton plant. Ideal for textiles, clothing, and linens due to its comfort and versatility.', 3),
  (24, 120, 'Leather', 'Durable, supple material from animal hides. Versatile and stylish for fashion, furniture, and accessories.', 8),
  (25, 1, 'Silk', 'Luxurious, smooth silk: natural fiber from silkworms. Gleaming, lightweight fabric prized for elegance and comfort.', 2);


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
  (1, '2023-03-29', 91, 'Completed', 11),
  (2, '2023-11-13', 14, 'Completed', 17),
  (3, '2023-05-30', 74, 'Completed', 14),
  (4, '2023-07-07', 65, 'Completed', 3),
  (5, '2023-02-05', 12, 'Completed', 24),
  (6, '2023-09-20', 87, 'Completed', 20),
  (7, '2023-07-18', 93, 'Completed', 19),
  (8, '2023-04-14', 46, 'Completed', 7),
  (9, '2023-01-04', 48, 'Completed', 11),
  (10, '2023-06-21', 72, 'Completed', 16),
  (11, '2023-02-16', 68, 'Completed', 24),
  (12, '2023-12-03', 7, 'Completed', 22),
  (13, '2023-10-15', 70, 'Completed', 2),
  (14, '2023-06-29', 90, 'Completed', 24),
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

INSERT INTO user_transaction (userID, transactionID, recyclerID) VALUES
  (19, 3, 1),
  (13, 13, 2),
  (4, 5, 3),
  (15, 21, 4),
  (9, 7, 5),
  (24, 22, 6),
  (15, 4, 7),
  (37, 21, 8),
  (7, 10, 9),
  (38, 25, 10),
  (18, 12, 1),
  (39, 6, 1),
  (5, 16, 2),
  (15, 11, 3),
  (40, 20, 4),
  (24, 19, 5),
  (2, 7, 6),
  (13, 9, 7),
  (41, 6, 8),
  (2, 17, 9),
  (14, 11, 10),
  (7, 3, 11),
  (13, 2, 1),
  (42, 20, 2),
  (18, 2, 3);

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


--posts --

INSERT INTO posts (title, content, like_count, userID, communityID) VALUES
('The Environmental Impact of Fast Fashion', 'Fast fashion contributes to pollution and waste. Explore how our clothing choices affect the planet.', 0, 1, 1),
('Recycling Textiles for a Greener Tomorrow', 'Learn about the benefits of recycling textiles and how it can lead to a more sustainable future. Join us in the recycling movement!', 0, 2, 2),
('Sustainable Fashion Brands Making a Difference', 'Discover fashion brands that prioritize sustainability. Support ethical practices in the fashion industry.', 0, 3, 3),
('Reducing Waste Through Clothing Upcycling', "Explore creative ways to upcycle old clothing. Let's turn fashion waste into unique and eco-friendly pieces!", 0, 4, 4),
('The True Cost of Cheap Fashion', "Unravel the hidden costs behind cheap fashion. From exploitation to environmental damage, it's time to rethink our choices.", 0, 5, 5),
('Tips for Eco-Friendly Wardrobes', 'Create an eco-friendly wardrobe with simple tips. Small changes in our clothing habits can lead to a big impact on the environment.', 0, 6, 6),
('Empowering Sustainable Fashion Movements', 'Join the global movement for sustainable fashion. Learn about initiatives and individuals making a positive change.', 0, 7, 7),
('Innovations in Textile Recycling', 'Explore the latest innovations in textile recycling. From advanced technologies to community-driven initiatives, discover the future of recycling.', 0, 8, 8),
('Fashion Revolution: Changing Industry Norms', 'Be part of the fashion revolution. Advocate for transparency, ethical practices, and environmental responsibility in the fashion industry.', 0, 9, 9),
('Upcycling Challenges: Transforming Textile Waste', 'Take on upcycling challenges to transform textile waste. Share your projects and inspire others to repurpose old clothing.', 0, 10, 10),
('Circular Fashion: Redefining the Apparel Lifecycle', 'Discover the concept of circular fashion. Explore how a circular economy can reshape the apparel lifecycle for a more sustainable future.', 0, 11, 11),
('Mindful Clothing Consumption Habits', "Practice mindful clothing consumption. From minimalism to conscious shopping, let's explore habits that promote a sustainable wardrobe.", 0, 12, 12),
('Community Spotlight: Sustainable Fashion Enthusiasts', 'Highlighting individuals and communities dedicated to sustainable fashion. Share your stories and inspire others to join the movement.', 0, 13, 13),
('Fashion and Climate Change: Connecting the Dots', 'Explore the link between fashion choices and climate change. Understand how our clothing decisions impact the global climate crisis.', 0, 14, 14),
('Revolutionizing Fashion Events for Sustainability', 'Rethinking fashion events for a sustainable future. From eco-friendly runways to conscious exhibitions, discover ways to revolutionize the industry.', 0, 15, 15),
('Art of Repair: Extending the Life of Clothing', 'Embrace the art of repair to extend the life of your clothing. Join the repair revolution and reduce fashion waste.', 0, 16, 16),
('Fashion Education for Sustainable Choices', 'Empower yourself with fashion education for sustainable choices. Learn about materials, production processes, and ethical brands.', 0, 17, 17),
('Textile Waste Challenges: Collaborative Solutions', 'Addressing textile waste challenges through collaboration. Join discussions on community-driven solutions and innovative approaches.', 0, 18, 18),
('Fashion Industry Transparency Initiatives', 'Explore transparency initiatives in the fashion industry. Support brands committed to openness and ethical practices.', 0, 19, 19),
('Local Efforts: Building Sustainable Fashion Communities', 'Celebrate local efforts in building sustainable fashion communities. Connect with like-minded individuals and organizations in your area.', 0, 20, 20);

