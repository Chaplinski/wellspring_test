CREATE DATABASE trains;

CREATE TABLE trains (
  id int NOT NULL AUTO_INCREMENT,
  train_line varchar(16),
  route_name varchar(64),
  run_number varchar(16),
  operator_id varchar(64),
  PRIMARY KEY (id)
);