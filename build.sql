drop table if exists users;
drop table if exists recyclers;
drop table if exists recycler_materials;
drop table if exists manufacturers;



CREATE TABLE users(
    userID int NOT NULL,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
    pass varchar(50) NOT NULL,
    contactNum int(10),
    user_location varchar(50),
    usertype varchar(20) CHECK (usertype IN ('recycler', 'manufacturer', 'individual_user')),
    PRIMARY KEY (userID)
) ENGINE=INNODB;


CREATE TABLE recyclers(
    companyID int NOT NULL,
    companyName varchar(50) NOT NULL,
    userID int NOT NULL,
    PRIMARY KEY (companyID),
    FOREIGN KEY (userID) REFERENCES users(userID)
) engine=innodb;


CREATE TABLE recycler_materials(
    companyID int NOT NULL,
    acceptedMaterial varchar(50),
    FOREIGN KEY (companyID) REFERENCES recyclers(companyID)
) engine=innodb;


CREATE TABLE manufacturers(
     manufacturerID int NOT NULL,
     companyName varchar(50) NOT NULL,
     userID int NOT NULL,
     PRIMARY KEY (manufacturerID),
     FOREIGN KEY (userID) REFERENCES users(userID)
) engine=innodb;


CREATE TABLE materials(
    materialID int NOT NULL,
    quantity int NOT NULL,
    materialName varchar(50),
    description TEXT NOT NULL,
    manufacturerID int NOT NULL,
    PRIMARY KEY (materialID),
    FOREIGN KEY (manufacturerID) REFERENCES manufacturers(manufacturerID)
) engine=innodb;


CREATE TABLE communities(
    communityID int NOT NULL,
    communityName varchar(50) NOT NULL,
    Description TEXT NOT NULL,
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
     transactionID int NOT NULL,
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



INSERT INTO 'users' ('userID','firstName','lastName','email','username','pass','contactNUm','user_location','userType')
VALUES
  (1,"Branden","Rich","nulla.vulputate@outlook.net","rbranden","SVR50RYU0KN","(747) 579-2386","P.O. Box 858, 7187 Integer Road","individual_user"),
  (2,"Laura","Mann","enim@google.ca","lmann","WPV18GNV4MN","1-660-389-8798","Ap #985-7507 Lectus. Avenue","recycler"),
  (3,"Shelley","Love","morbi.tristique@yahoo.edu","slove","OZU75RYK9OU","(574) 423-0552","994-8803 Faucibus Avenue","individual_user"),
  (4,"Illana","Wheeler","dapibus.quam.quis@icloud.edu","iwheeler","ICN85EBC3JP","(426) 548-1815","P.O. Box 672, 6233 Ante. Ave","individual_user"),
  (5,"Juliet","Mcleod","est@hotmail.com","jmcleod","UNB38WIP5DH","1-445-818-5484","124-3288 Sollicitudin St.","recycler"),
  (6,"Erich","Gentry","lorem.ipsum.sodales@outlook.ca","egentry","OOC21PBP6EV","1-482-316-3347","Ap #526-5108 Facilisis. St.","recycler"),
  (7,"Micah","Rosales","risus.donec@hotmail.net","yrivera","HVG61QFO7AN","1-624-731-4078","Ap #259-4007 Odio Street","recycler"),
  (8,"Yoko","Rivera","libero.mauris@outlook.org","yrivera","VPJ56SKE4TY","1-436-152-4706","Ap #904-491 Quisque Avenue","recycler"),
  (9,"Alan","Butler","sed@hotmail.org","abutler","ZDI77INO1TS","(601) 883-0795","1691 Curae Ave","manufacturer"),
  (10,"Gabriel","Moody","donec.fringilla.donec@outlook.edu","gmoody","HHB41VYL8HB","1-285-187-7761","656-6317 Nisi. Street","individual_user"),
  (11,"Anthony","Hobbs","placerat.velit.quisque@google.org","ahobbs","NRL47EWL5OY","(879) 342-5716","684-588 Eget Street","recycler"),
  (12,"Hamish","English","vitae.erat.vel@icloud.net","henglish","NBD27UKW6JI","(341) 665-6067","Ap #551-8562 Fusce Ave","manufacturer"),
  (13,"Fitzgerald","Gordon","ultricies@hotmail.com","fgordon","YAA14CEN9XC","1-466-782-4882","2043 Ullamcorper Ave","recycler"),
  (14,"Wallace","Bean","vitae@hotmail.ca","wbean","VXW23LPP3SE","1-948-681-6175","335-6999 Consequat, Ave","individual_user"),
  (15,"Joy","Gentry","imperdiet.ullamcorper@google.couk","jgentry","IEE63UPS8KD","(516) 510-5548","Ap #680-2485 Vel St.","recycler"),
  (16,"Igor","Chen","tortor.nunc.commodo@outlook.net","ichen","YLY05PRE2HP","(744) 351-2703","7691 Adipiscing St.","individual_user"),
  (17,"Riley","Pittman","tincidunt.dui.augue@outlook.net","rpittman","ELF30HQA9VF","(828) 961-6516","855-840 Dictum Rd.","manufacturer"),
  (18,"Shad","Underwood","sodales.at.velit@aol.org","sunderwood","XYK94XOH3JK","1-736-253-4713","Ap #773-7387 Magnis Street","manufacturer"),
  (19,"Nayda","Rodriquez","praesent@google.com","nrodriquez","LOP32FTB3OC","1-503-265-2037","396-1225 Donec Ave","manufacturer"),
  (20,"Nadine","Hopper","odio.phasellus@icloud.com","nhopper","GRH47MXV3JN","1-256-787-7639","5332 Ultrices Avenue","recycler"),
  (21,"Maggie","Sanchez","orci.ut@icloud.com","msanchez","HBU33ABK5XY","(386) 493-9187","P.O. Box 636, 9618 Vitae Rd.","recycler"),
  (22,"Aiko","Douglas","aliquet.magna.a@icloud.org","adouglas","HGX69LCK7GH","1-287-914-2946","Ap #814-4525 Pharetra Rd.","recycler"),
  (23,"Anthony","Stevens","sed.pede@aol.ca","astevens","FOB75AKX5UR","1-471-377-2276","Ap #548-3698 Donec Road","individual_user"),
  (24,"Keaton","Vincent","lectus@google.ca","kvincent","SQT44HKR6TP","(769) 749-5611","P.O. Box 570, 6358 Et Street","recycler"),
  (25,"Kaye","Lawrence","ac.mi@protonmail.com","klawrence","UMW49GIH8MJ","1-119-945-3846","P.O. Box 685, 1976 Placerat Av.","recycler");


INSERT INTO 'recyclers' ('companyID','companyName','userID')
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
  (25,"Iaculis Nec Eleifend Corp.",25) engine=innodb;

INSERT INTO 'recycler_materials' ('companyID','acceptedMaterial')
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


INSERT INTO 'manufacturers' ('manufacturerID','companyName','userID')
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


INSERT INTO 'materials' ('materialID','quantity','materialName','manufacturerID')
VALUES


INSERT INTO 'communities' ('communityID','communityName','communityRules','manufacturerID')
VALUES