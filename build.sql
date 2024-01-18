CREATE TABLE users(
    userID int NOT NULL,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    Email varchar(50) NOT NULL,
    Username varchar(50) NOT NULL,
    Password varchar(50) NOT NULL,
    contactNum int(10),
    Location varchar(50),
    Usertype varchar(20) CHECK (usertype IN ('recycler', 'manufacturer', 'individual_user')),
    PRIMARY KEY (userID)
) ENGINE=INNODB;


CREATE TABLE recyclers(
    companyID int NOT NULL,
    companyName varchar(50) NOT NULL,
    acceptedMaterials varchar(50) NOT NULL,
    userID int NOT NULL,
    PRIMARY KEY (companyID),
    FOREIGN KEY (userID) REFERENCES users(userID)
) engine=innodb;


FOREIGN KEY (PersonID) REFERENCES Persons(PersonID)


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
