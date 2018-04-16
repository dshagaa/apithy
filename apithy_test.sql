
DROP DATABASE IF EXISTS apithy_test;
CREATE DATABASE apithy_test
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

SET NAMES 'utf8';

USE apithy_test;


-- Definition for table answer_options
CREATE TABLE answer_options (
  option_id INT(2) NOT NULL AUTO_INCREMENT,
  question_id INT(4) NOT NULL,
  option_description VARCHAR(50) DEFAULT NULL,
  option_value INT(3) NOT NULL,
  PRIMARY KEY (option_id),
  INDEX FK_answer_options_answers_question_id (question_id),
  CONSTRAINT FK_answer_options_questions_question_id FOREIGN KEY (question_id)
    REFERENCES questions(question_id) ON DELETE CASCADE ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table answers
CREATE TABLE answers (
  answer_id INT(5) NOT NULL AUTO_INCREMENT,
  question_id INT(5) NOT NULL,
  answer_value INT(3) DEFAULT NULL,
  user_id INT(10) DEFAULT NULL,
  PRIMARY KEY (answer_id, question_id),
  CONSTRAINT FK_answers_answer_options_question_id FOREIGN KEY (question_id)
    REFERENCES answer_options(question_id) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table evaluation_methods
CREATE TABLE evaluation_methods (
  method_id INT(5) NOT NULL AUTO_INCREMENT,
  method_name VARCHAR(30) NOT NULL,
  method_formule VARCHAR(255) NOT NULL,
  PRIMARY KEY (method_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table evaluations
CREATE TABLE evaluations (
  evaluation_id INT(10) NOT NULL AUTO_INCREMENT,
  survey_id INT(5) NOT NULL,
  user_id INT(10) NOT NULL,
  result VARCHAR(255) DEFAULT NULL,
  comments TEXT DEFAULT NULL,
  PRIMARY KEY (evaluation_id),
  CONSTRAINT FK_evaluations_user_surveys_survey_id FOREIGN KEY (survey_id)
    REFERENCES user_surveys(survey_id) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table profiles
CREATE TABLE profiles (
  user_id INT(10) NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) DEFAULT NULL,
  address VARCHAR(255) DEFAULT NULL,
  age INT(2) DEFAULT NULL,
  PRIMARY KEY (user_id),
  CONSTRAINT FK_profiles_users_user_id FOREIGN KEY (user_id)
    REFERENCES users(user_id) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table question_types
CREATE TABLE question_types (
  type_id INT(3) NOT NULL AUTO_INCREMENT,
  type_description VARCHAR(7) NOT NULL,
  PRIMARY KEY (type_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table questions
CREATE TABLE questions (
  question_id INT(5) NOT NULL AUTO_INCREMENT,
  survey_id INT(5) NOT NULL,
  question_description TEXT NOT NULL,
  question_instruction TEXT DEFAULT NULL,
  question_type INT(3) NOT NULL,
  PRIMARY KEY (question_id),
  INDEX UK_questions_survey_id (survey_id),
  CONSTRAINT FK_questions_question_types_type_id FOREIGN KEY (question_type)
    REFERENCES question_types(type_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_questions_surveys_survey_id FOREIGN KEY (survey_id)
    REFERENCES surveys(survey_id) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table survey_logs
CREATE TABLE survey_logs (
  log_id INT(20) NOT NULL AUTO_INCREMENT,
  survey_id INT(5) NOT NULL,
  user_id INT(10) NOT NULL,
  action VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (log_id, survey_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table survey_method
CREATE TABLE survey_method (
  survey_id INT(5) NOT NULL,
  method_id INT(5) NOT NULL,
  CONSTRAINT FK_survey_method_evaluationmethods_method_id FOREIGN KEY (method_id)
    REFERENCES evaluation_methods(method_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_survey_method_surveys_survey_id FOREIGN KEY (survey_id)
    REFERENCES surveys(survey_id) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table surveys
CREATE TABLE surveys (
  survey_id INT(5) NOT NULL AUTO_INCREMENT,
  survey_name VARCHAR(255) NOT NULL,
  survey_description VARCHAR(255) DEFAULT NULL,
  min_age INT(2) NOT NULL DEFAULT 0,
  max_age INT(2) DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  expire_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (survey_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table user_logs
CREATE TABLE user_logs (
  log_id INT(20) NOT NULL AUTO_INCREMENT,
  user_id INT(10) NOT NULL COMMENT '0 is Guest',
  action VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (log_id, user_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table user_surveys
CREATE TABLE user_surveys (
  user_id INT(10) NOT NULL,
  survey_id INT(5) NOT NULL,
  completed TINYINT(1) DEFAULT 0,
  last_question INT(3) DEFAULT 1,
  started_at TIMESTAMP NULL DEFAULT NULL,
  finished_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (user_id, survey_id),
  CONSTRAINT FK_user_surveys_surveys_survey_id FOREIGN KEY (survey_id)
    REFERENCES surveys(survey_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT FK_user_surveys_users_user_id FOREIGN KEY (user_id)
    REFERENCES users(user_id) ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = INNODB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Definition for table users
CREATE TABLE users (
  user_id INT(10) NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) DEFAULT NULL,
  password VARCHAR(255) DEFAULT NULL,
  email VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  banned TINYINT(1) DEFAULT 0,
  token VARCHAR(100) DEFAULT NULL,
  remember_token VARCHAR(100) DEFAULT NULL,
  last_login TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP NULL DEFAULT NULL,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  deleted_at TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (user_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;