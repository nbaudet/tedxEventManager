	-- ---------------------------------------------------------------------
-- ---------------------------------------------------------------------
-- Script M40TEDxLausanne.sql
--
-- Date de création : 11.06.2013
-- Date de maj :
-- Version : 2013.01
-- Modifications :
-- Auteur : Robin Jespierre
--

	-- ---------------------------------------------------------
	-- ---------------------------------------------------------
	-- Désactive l'auto commit, pour cette session
	-- Commence la transaction
	SET autocommit=0;
	START TRANSACTION;
	-- ---------------------------------------------------------
	-- ---------------------------------------------------------
	-- BD par défaut en InnoDB
	SET storage_engine=INNODB;

	-- ------------------------------------------
	/*Création des tables*/
--
-- Structure de la table Person
--
	DROP TABLE IF EXISTS Person;
	CREATE TABLE Person(
		No 				INTEGER (11) NOT NULL AUTO_INCREMENT,
		Name 				VARCHAR (300) NOT NULL,
		Firstname 			VARCHAR (300) NOT NULL,
		DateOfBirth 			DATE NOT NULL,
		Address 			VARCHAR (600) NOT NULL,
		City 				VARCHAR (600) NOT NULL,
		Country 			VARCHAR (200) NOT NULL,
		PhoneNumber 			VARCHAR (200) NOT NULL,
		Email				VARCHAR (200) NOT NULL,
		Description			VARCHAR (600),
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (No),
		KEY No (No),
		KEY Email (Email)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table Speaker
--
	DROP TABLE IF EXISTS Speaker;
	CREATE TABLE Speaker(
		PersonNo 			INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (PersonNo),
		KEY PersonNo (PersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Organizer
--
	DROP TABLE IF EXISTS Organizer;
	CREATE TABLE Organizer(
		PersonNo 			INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (PersonNo),
		KEY PersonNo (PersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Participant
--
	DROP TABLE IF EXISTS Participant;
	CREATE TABLE Participant(
		PersonNo 			INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (PersonNo),
		KEY PersonNo (PersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table TeamRole
--
	DROP TABLE IF EXISTS TeamRole;
	CREATE TABLE TeamRole(
		Name				VARCHAR (250) NOT NULL,
		IsMemberOf			VARCHAR (250),
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (Name),
		KEY Name (Name)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Event
--
	DROP TABLE IF EXISTS Event;
	CREATE TABLE Event(
		No 				INTEGER (11) NOT NULL AUTO_INCREMENT,
		MainTopic			VARCHAR (300) NOT NULL,
		StartingDate 			DATE NOT NUll,
		EndingDate			DATE NOT NUll,
		StartingTime			TIME NOT NULL,
		EndingTime			TIME NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (No),
		KEY No (No)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table Location
--
	DROP TABLE IF EXISTS Location;
	CREATE TABLE Location(
		Name 				VARCHAR (250) NOT NULL,
		Address			VARCHAR (300) NOT NULL,
		City			VARCHAR (300) NOT NULL,
		Country			VARCHAR (300) NOT NULL,
		Direction			VARCHAR (300),
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (Name),
		KEY Name (Name)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table Affectation
--
	DROP TABLE IF EXISTS Affectation;
		CREATE TABLE Affectation(
		OrganizerPersonNo 		INTEGER (11) NOT NULL,
		TeamRoleName			VARCHAR (250) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (OrganizerPersonNo),
		KEY OrganizerPersonNo (OrganizerPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Slot
--
	DROP TABLE IF EXISTS Slot;
	CREATE TABLE Slot(
		No 				INTEGER (11) NOT NULL AUTO_INCREMENT,
		EventNo 			INTEGER (11) NOT NULL,
		HappeningDate			DATE NOT NUll,
		StartingTime			TIME NOT NULL,
		EndingTime			TIME NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (No, EventNo),
		KEY No (No),
		KEY EventNo (EventNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table CoOrganization
--
	DROP TABLE IF EXISTS CoOrganization;
	CREATE TABLE CoOrganization(
		EventNo				INTEGER (11) NOT NULL,
		SpeakerPersonNo 		INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (EventNo, SpeakerPersonNo),
		KEY EventNo (EventNo),
		KEY SpeakerPersonNo (SpeakerPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Role
--
	DROP TABLE IF EXISTS Role;
	CREATE TABLE Role(
		Name				VARCHAR (250) NOT NULL,
		EventNo				INTEGER (11) NOT NULL,
		OrganizerPersonNo 		INTEGER (11) NOT NULL,
		Level				 INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (Name, EventNo, OrganizerPersonNo),
		KEY Name (Name),
		KEY EventNo (EventNo),
		KEY OrganizerPersonNo (OrganizerPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Motivation
--
	DROP TABLE IF EXISTS Motivation;
		CREATE TABLE Motivation(
		Text				VARCHAR(250) NOT NULL,
		EventNo				INTEGER (11) NOT NULL,
		ParticipantPersonNo 		INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (Text, EventNo, ParticipantPersonNo),
		KEY Text (Text),
		KEY EventNo (EventNo),
		KEY ParticipantPersonNo (ParticipantPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Registration
--
	DROP TABLE IF EXISTS Registration;
	CREATE TABLE Registration(
		Status				VARCHAR (100) NOT NULL,
		EventNo				INTEGER (11) NOT NULL,
		ParticipantPersonNo 	INTEGER (11) NOT NULL,
		RegistrationDate 		DATE NOT NULL,
		Type			VARCHAR (100) NOT NULL,
		TypeDescription			VARCHAR(1000),
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (Status, EventNo, ParticipantPersonNo),
		KEY Status (Status),
		KEY EventNo (EventNo),
		KEY ParticipantPersonNo (ParticipantPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Keyword
--
	DROP TABLE IF EXISTS Keyword;
	CREATE TABLE Keyword(
		Value				VARCHAR (100) NOT NULL,
		EventNo				INTEGER (11) NOT NULL,
		PersonNo 		INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (Value, EventNo, PersonNo),
		KEY Value (Value),
		KEY EventNo (EventNo),
		KEY PersonNo (PersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Participation
--
	DROP TABLE IF EXISTS Participation;
	CREATE TABLE Participation(
		SlotNo				INTEGER (11) NOT NULL,
		SlotEventNo			INTEGER (11) NOT NULL,
		ParticipantPersonNo 	INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (SlotNo, SlotEventNo, ParticipantPersonNo),
		KEY SlotNo (SlotNo),
		KEY SlotEventNo (SlotEventNo),
		KEY ParticipantPersonNo (ParticipantPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Place
--
	DROP TABLE IF EXISTS Place;
	CREATE TABLE Place(
		No				INTEGER (11) NOT NULL AUTO_INCREMENT,
		SlotNo				INTEGER (11) NOT NULL,
		SlotEventNo			INTEGER (11) NOT NULL,
		SpeakerPersonNo 		INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (No, SlotNo, SlotEventNo, SpeakerPersonNo),
		KEY No (No),
		KEY SlotNo (SlotNo),
		KEY SlotEventNo (SlotEventNo),
		KEY SpeakerPersonNo (SpeakerPersonNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table Member
--
	DROP TABLE IF EXISTS Member;
	CREATE TABLE Member(
		ID 				VARCHAR (250) NOT NULL,
		Password 			VARCHAR (300) NOT NULL,
		PersonNo 			INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (ID),
		KEY ID (ID)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Unit
--
	DROP TABLE IF EXISTS Unit;
	CREATE TABLE Unit(
		No 				INTEGER (11) NOT NULL AUTO_INCREMENT,
		Name			  VARCHAR (300) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (No),
		KEY No (No)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table Access
--
	DROP TABLE IF EXISTS Access;
	CREATE TABLE Access(
		No 				INTEGER (11) NOT NULL AUTO_INCREMENT,
		Service				VARCHAR (300) NOT NULL,
		Type				VARCHAR (300) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (No)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11;
--
-- Structure de la table Permission
--
	DROP TABLE IF EXISTS Permission;
	CREATE TABLE Permission(
		AccessNo			INTEGER (11) NOT NULL,
		UnitNo				INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (AccessNo, UnitNo),
		KEY AccessNo (AccessNo),
		KEY UnitNo (UnitNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Structure de la table Membership
--
	DROP TABLE IF EXISTS Membership;
	CREATE TABLE Membership(
		MemberID 			VARCHAR (250) NOT NULL,
		UnitNo				INTEGER (11) NOT NULL,
		IsArchived			BOOLEAN NOT NULL DEFAULT 0,
		PRIMARY KEY (MemberID, UnitNo),
		KEY MemberID (MemberID),
		KEY UnitNo (UnitNo)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

	-- -----------------------------------------------------------------------
	/*Création des clés étrangères*/

	ALTER TABLE Speaker
		ADD CONSTRAINT Speaker_fkey1
		FOREIGN KEY (PersonNo) REFERENCES Person(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Organizer
		ADD CONSTRAINT Organizer_fkey1
		FOREIGN KEY (PersonNo) REFERENCES Person(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Participant
		ADD CONSTRAINT Participant_fkey1
		FOREIGN KEY (PersonNo) REFERENCES Person(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Affectation
		ADD CONSTRAINT Affectation_fkey1
		FOREIGN KEY (OrganizerPersonNo) REFERENCES Organizer(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Affectation
		ADD CONSTRAINT Affectation_fkey2
		FOREIGN KEY (TeamRoleName) REFERENCES TeamRole(Name) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Slot
		ADD CONSTRAINT Slot_fkey1
		FOREIGN KEY (EventNo) REFERENCES Event(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE CoOrganization
		ADD CONSTRAINT CoOrganization_fkey1
		FOREIGN KEY (EventNo) REFERENCES Event(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE CoOrganization
		ADD CONSTRAINT CoOrganization_fkey2
		FOREIGN KEY (SpeakerPersonNo) REFERENCES Speaker(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Role
		ADD CONSTRAINT Role_fkey1
		FOREIGN KEY (EventNo) REFERENCES Event(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Role
		ADD CONSTRAINT Role_fkey2
		FOREIGN KEY (OrganizerPersonNo) REFERENCES Organizer(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;
	
	ALTER TABLE Motivation
		ADD CONSTRAINT Motivation_fkey1
		FOREIGN KEY (EventNo) REFERENCES Event(No) ON DELETE NO ACTION ON UPDATE NO ACTION;	

	ALTER TABLE Motivation
		ADD CONSTRAINT Motivation_fkey2
		FOREIGN KEY (ParticipantPersonNo) REFERENCES Participant(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Registration
		ADD CONSTRAINT Registration_fkey1
		FOREIGN KEY (EventNo) REFERENCES Event(No) ON DELETE NO ACTION ON UPDATE NO ACTION;	

	ALTER TABLE Registration
		ADD CONSTRAINT Registration_fkey2
		FOREIGN KEY (ParticipantPersonNo) REFERENCES Participant(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;	
	
	ALTER TABLE Keyword
		ADD CONSTRAINT Keyword_fkey1
		FOREIGN KEY (EventNo) REFERENCES Event(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Keyword
		ADD CONSTRAINT Keyword_fkey2
		FOREIGN KEY (PersonNo) REFERENCES Person(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Participation
		ADD CONSTRAINT Participation_fkey1
		FOREIGN KEY (SlotNo) REFERENCES Slot(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Participation
		ADD CONSTRAINT Participation_fkey2
		FOREIGN KEY (SlotEventNo) REFERENCES Slot(EventNo) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Participation
		ADD CONSTRAINT Participation_fkey3
		FOREIGN KEY (ParticipantPersonNo) REFERENCES Participant(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;
	
	ALTER TABLE Place
		ADD CONSTRAINT Place_fkey1
		FOREIGN KEY (SlotNo) REFERENCES Slot(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Place
		ADD CONSTRAINT Place_fkey2
		FOREIGN KEY (SlotEventNo) REFERENCES Slot(EventNo) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Place
		ADD CONSTRAINT Place_fkey3
		FOREIGN KEY (SpeakerPersonNo) REFERENCES Speaker(PersonNo) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Permission
		ADD CONSTRAINT Permission_fkey1
		FOREIGN KEY (AccessNo) REFERENCES Access(No) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Permission
		ADD CONSTRAINT Permission_fkey2
		FOREIGN KEY (UnitNo) REFERENCES Unit(No) ON DELETE NO ACTION ON UPDATE NO ACTION;
	
	ALTER TABLE Membership
		ADD CONSTRAINT Membership_fkey1
		FOREIGN KEY (MemberID) REFERENCES Member(ID) ON DELETE NO ACTION ON UPDATE NO ACTION;

	ALTER TABLE Membership
		ADD CONSTRAINT Membership_fkey2
		FOREIGN KEY (UnitNo) REFERENCES Unit(No) ON DELETE NO ACTION ON UPDATE NO ACTION;
	
	ALTER TABLE TeamRole
		ADD CONSTRAINT TeamRole_fkey1
		FOREIGN KEY (IsMemberOf) REFERENCES TeamRole(Name) ON DELETE NO ACTION ON UPDATE NO ACTION;

	-- ---------------------------------------------------------
	-- ---------------------------------------------------------
	/*Commit, exécute la transaction*/
	COMMIT;