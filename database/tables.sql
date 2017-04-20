
CREATE TABLE languages
(
  pkLangID INT NOT NULL AUTO_INCREMENT,
  langName TINYTEXT NOT NULL,
  PRIMARY KEY (pkLangID)
);

CREATE TABLE users
(
  pkUserID INT NOT NULL AUTO_INCREMENT,
  userName TINYTEXT NOT NULL,
  password TINYTEXT NOT NULL,
  email TINYTEXT NOT NULL,
  lastVisit TIMESTAMP,
  fullName TINYTEXT,
  registrationDate TIMESTAMP NOT NULL,
  pkLangID INT,
  PRIMARY KEY (pkUserID),
  FOREIGN KEY (pkLangID) REFERENCES languages(pkLangID)
);

CREATE TABLE authorization_access_types
(
  pkAuthAccessTypeID INT NOT NULL AUTO_INCREMENT,
  accessTypeName TINYTEXT NOT NULL,
  accessTypeDescription TEXT,
  PRIMARY KEY (pkAuthAccessTypeID)
);

CREATE TABLE authorization_groups
(
  pkAuthGroupID INT NOT NULL AUTO_INCREMENT,
  authGroupName TINYTEXT NOT NULL,
  PRIMARY KEY (pkAuthGroupID)
);


CREATE TABLE auth_group_access_map
(
  pkAGAMap INT NOT NULL AUTO_INCREMENT,
  pkAuthGroupID INT NOT NULL,
  pkAuthAccessTypeID INT NOT NULL,
  PRIMARY KEY (pkAGAMap),
  FOREIGN KEY (pkAuthGroupID) REFERENCES authorization_groups(pkAuthGroupID),
  FOREIGN KEY (pkAuthAccessTypeID) REFERENCES authorization_access_types(pkAuthAccessTypeID)
);

CREATE TABLE auth_group_members
(
  pkAGMembers INT NOT NULL AUTO_INCREMENT,
  pkUserID INT NOT NULL,
  pkAuthGroupID INT NOT NULL,
  PRIMARY KEY (pkAGMembers),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID),
  FOREIGN KEY (pkAuthGroupID) REFERENCES authorization_groups(pkAuthGroupID)
);

CREATE TABLE user_data_types
(
  pkUserDataTypeID INT NOT NULL AUTO_INCREMENT,
  dataTypeName TINYTEXT NOT NULL,
  PRIMARY KEY (pkUserDataTypeID)
);

CREATE TABLE user_data
(
  pkUserData INT NOT NULL AUTO_INCREMENT,
  pkUserID INT NOT NULL,
  pkUserDataTypeID INT NOT NULL,
  dataValue TEXT NOT NULL,
  PRIMARY KEY (pkUserData),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID),
  FOREIGN KEY (pkUserDataTypeID) REFERENCES user_data_types(pkUserDataTypeID)
);

CREATE TABLE sentences
(
  pkSentenceID INT NOT NULL AUTO_INCREMENT,
  sentence TEXT NOT NULL,
  creationDate DATETIME,
  pkLangID INT,
  PRIMARY KEY (pkSentenceID),
  FOREIGN KEY (pkLangID) REFERENCES languages(pkLangID)
);

CREATE TABLE team_member_types
(
  pkMemTypeID INT NOT NULL AUTO_INCREMENT,
  memTypeName TINYTEXT NOT NULL,
  memTypeDescription TEXT,
  PRIMARY KEY (pkMemTypeID)
);

CREATE TABLE teams
(
  pkTeamID INT NOT NULL AUTO_INCREMENT,
  teamName TINYTEXT,
  teamDescription TEXT,
  creationDate TIMESTAMP NOT NULL,
  pkUserID INT NOT NULL,
  PRIMARY KEY (pkTeamID),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID)
);

CREATE TABLE team_members
(
  pkTeamMemberID INT NOT NULL AUTO_INCREMENT,
  since TIMESTAMP NOT NULL,
  pkTeamID INT NOT NULL,
  pkUserID INT NOT NULL,
  pkMemTypeID INT NOT NULL,
  PRIMARY KEY (pkTeamMemberID),
  FOREIGN KEY (pkTeamID) REFERENCES teams(pkTeamID),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID),
  FOREIGN KEY (pkMemTypeID) REFERENCES team_member_types(pkMemTypeID)
);

CREATE TABLE team_chat_topics
(
  pkTopicID INT NOT NULL AUTO_INCREMENT,
  topicTitle TINYTEXT NOT NULL,
  topicContent LONGTEXT NOT NULL,
  pkTeamID INT NOT NULL,
  pkUserID INT NOT NULL,
  PRIMARY KEY (pkTopicID),
  FOREIGN KEY (pkTeamID) REFERENCES teams(pkTeamID),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID)
);

CREATE TABLE team_chat_comments
(
  pkCommentID INT NOT NULL AUTO_INCREMENT,
  pkTopicID INT NOT NULL,
  pkUserID INT NOT NULL,
  commentContent MEDIUMTEXT NOT NULL,
  commentDate TIMESTAMP,
  PRIMARY KEY (pkCommentID),
  FOREIGN KEY (pkTopicID) REFERENCES team_chat_topics(pkTopicID),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID)
);

CREATE TABLE support_media_sources
(
  pkSMediaSourceID INT NOT NULL AUTO_INCREMENT,
  sMediaSourceName TINYTEXT NOT NULL,
  sMediaSourceDescription TEXT,
  PRIMARY KEY (pkSMediaSourceID)
);

CREATE TABLE supported_media_types
(
  pkSupMediaTypeID INT NOT NULL AUTO_INCREMENT,
  supMediaTypeName TINYTEXT NOT NULL,
  supMediaTypeDescription TEXT,
  PRIMARY KEY (pkSupMediaTypeID)
);

CREATE TABLE subtitle_types
(
  pkSubtitleTypeID INT NOT NULL AUTO_INCREMENT,
  subtitleTypeName TINYTEXT NOT NULL,
  subtitleTypeDescription TEXT,
  PRIMARY KEY (pkSubtitleTypeID)
);


CREATE TABLE subtitles
(
  pkSubtitleID INT NOT NULL AUTO_INCREMENT,
  subtitleName TINYTEXT,
  subtitleDescription TEXT,
  pkTmID INT NOT NULL,
  pkSubtitleTypeID INT NOT NULL,
  pkUserID INT NOT NULL,
  pkLangID INT,
  PRIMARY KEY (pkSubtitleID),
  FOREIGN KEY (pkTmID) REFERENCES translation_media(pkTmID),
  FOREIGN KEY (pkSubtitleTypeID) REFERENCES subtitle_types(pkSubtitleTypeID),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID),
  FOREIGN KEY (pkLangID) REFERENCES languages(pkLangID)
);

CREATE TABLE translation_media
(
  pkTmID INT NOT NULL AUTO_INCREMENT,
  tmName TINYTEXT,
  tmDescription TEXT,
  creationDate TIMESTAMP,
  pkUserID INT NOT NULL,
  pkSMediaSourceID INT NOT NULL,
  pkSupMediaTypeID INT NOT NULL,
  pkLangID INT,
  pkTeamID INT,
  nativeLangTranslationID INT,
  PRIMARY KEY (pkTmID),
  FOREIGN KEY (pkUserID) REFERENCES users(pkUserID),
  FOREIGN KEY (pkSMediaSourceID) REFERENCES support_media_sources(pkSMediaSourceID),
  FOREIGN KEY (pkSupMediaTypeID) REFERENCES supported_media_types(pkSupMediaTypeID),
  FOREIGN KEY (pkLangID) REFERENCES languages(pkLangID),
  FOREIGN KEY (pkTeamID) REFERENCES teams(pkTeamID),
  FOREIGN KEY (nativeLangTranslationID) REFERENCES subtitles(pkSubtitleID)
);

CREATE TABLE sentence_translations
(
  pkSentenceTranslationID INT NOT NULL AUTO_INCREMENT,
  StartTime TIME,
  FinishTime TIME,
  OrderNumber INT,
  pkSubtitleID INT NOT NULL,
  pkSourceSentenceID INT NOT NULL,
  pkTranslatedSentenceID INT NOT NULL,
  PRIMARY KEY (pkSentenceTranslationID),
  FOREIGN KEY (pkSourceSentenceID) REFERENCES sentences(pkSentenceID),
  FOREIGN KEY (pkSubtitleID) REFERENCES subtitles(pkSubtitleID),
  FOREIGN KEY (pkTranslatedSentenceID) REFERENCES sentences(pkSentenceID)
);
