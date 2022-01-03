;
CREATE DATABASE super_market DEFAULT CHARACTER SET = 'utf8mb4';
CREATE TABLE suppliers(
  supllier_id VARCHAR(10) PRIMARY Key,
  s_name VARCHAR(10) NOT NULL,
  s_email VARCHAR(50) NOT NULL
);
CREATE Table supplier_phone(
  _id VARCHAR(10),
  phone VARCHAR(50),
  CONSTRAINT FK_supplier PRIMARY KEY(_id, phone),
  CONSTRAINT FK_supplier2 FOREIGN KEY(_id) REFERENCES suppliers(supllier_id)
);
CREATE TABLE product (
  _id VARCHAR(10) PRIMARY KEY,
  p_name VARCHAR(20) NOT NULL,
  price DOUBLE NOT NULL,
  p_type VARCHAR(20),
  quantityInMarket DOUBLE NOT NULL,
  quantityInStore DOUBLE NOT NULL,
  exportPrice DOUBLE NOT NULL,
  importPrice DOUBLE NOT NULL,
  unity VARCHAR(10) NOT NULL,
  PackagePecies DOUBLE NOT NULL,
  supllier_id VARCHAR(10),
  CONSTRAINT FK_supplier FOREIGN KEY(supllier_id) REFERENCES suppliers(supllier_id)
);
CREATE Table outCome(
  purchases DOUBLE NOT NULL,
  sales DOUBLE NOT NULL,
  total_profits DOUBLE NOT NULL,
  outcome_month VARCHAR(10) PRIMARY KEY
);
CREATE Table recipt (
  _id VARCHAR(10) PRIMARY KEY,
  recipt_data TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  discount DOUBLE NOT NULL
);
CREATE Table product_recipt(
  product_id VARCHAR(10),
  recipt_id VARCHAR(10),
  quantity DOUBLE NOT NULL,
  CONSTRAINT FK_product_recipt PRIMARY KEY(product_id, recipt_id),
  CONSTRAINT FK_product FOREIGN KEY(product_id) REFERENCES product(_id),
  CONSTRAINT FK_recipt FOREIGN KEY(recipt_id) REFERENCES recipt(_id)
);
CREATE Table total_price_recipt(
  _id VARCHAR(10),
  total_profits DOUBLE,
  total_price DOUBLE,
  r_Type VARCHAR(10),
  CONSTRAINT FK_recipt PRIMARY KEY(_id),
  CONSTRAINT FK_recipt2 FOREIGN KEY(_id) REFERENCES recipt(_id)
);
/* delere all recipt to clear recipt from 3 table */
CREATE PROCEDURE `delete_all_recipt`(input__id VARCHAR(10)) BEGIN
DELETE FROM
  total_price_recipt
WHERE
  _id = input__id;
DELETE FROM
  product_recipt
WHERE
  recipt_id = input__id;
DELETE FROM
  recipt
WHERE
  _id = input__id;
END
/*INSERT TO PRODUCT*/
CREATE PROCEDURE `insert_product`(
  input__id VARCHAR(10),
  input_p_name VARCHAR(20),
  input_price DOUBLE,
  input_p_type VARCHAR(20),
  input_exportPrice DOUBLE,
  input_importPrice DOUBLE,
  input_unity VARCHAR(10),
  input_PackagePecies DOUBLE,
  input_supllier_id VARCHAR(10)
) BEGIN
insert into
  product (
    _id,
    p_name,
    price,
    p_type,
    quantityInMarket,
    quantityInStore,
    exportPrice,
    importPrice,
    unity,
    PackagePecies,
    supllier_id
  )
values
  (
    input__id,
    input_p_name,
    input_price,
    input_p_type,
    0,
    0,
    input_exportPrice,
    input_importPrice,
    input_unity,
    input_PackagePecies,
    input_supllier_id
  );
END
/*insert TO supplier*/
CREATE PROCEDURE `insert_supplier`(
  input_id VARCHAR(10),
  input_s_name VARCHAR(10),
  input_s_email VARCHAR(50)
) BEGIN
INSERT INTO
  suppliers (supllier_id, s_name, s_email)
VALUES(input_id, input_s_name, input_s_email);
END
/*insert supplier phone*/
CREATE PROCEDURE `insert_supplier_phone`(
  input_id VARCHAR(10),
  input_phone VARCHAR(255)
) BEGIN
INSERT INTO
  supplier_phone (_id, phone)
VALUES
  (input_id, input_phone);
END
/*update product */
CREATE PROCEDURE `update_product`(
  input__id VARCHAR(10),
  input_p_name VARCHAR(20),
  input_price DOUBLE,
  input_p_type VARCHAR(20),
  input_quantityInMarket DOUBLE,
  input_quantityInStore DOUBLE,
  input_exportPrice DOUBLE,
  input_importPrice DOUBLE,
  input_unity VARCHAR(10),
  input_PackagePecies DOUBLE,
  input_supllier_id VARCHAR(10)
) BEGIN
UPDATE
  product
SET
  p_name = input_p_name,
  price = input_price,
  p_type = input_p_type,
  quantityInMarket = input_quantityInMarket,
  quantityInStore = input_quantityInStore,
  exportPrice = input_exportPrice,
  importPrice = input_importPrice,
  unity = input_unity,
  PackagePecies = input_PackagePecies,
  supllier_id = input_supllier_id
WHERE
  _id = input__id;
END
/*update quantity in market when user take item or when supplier supply item*/
CREATE PROCEDURE `update_quantity_in_market`(
  input__id VARCHAR(10),
  input_quantityInMarket DOUBLE
) BEGIN
UPDATE
  product
SET
  quantityInMarket = quantityInMarket + input_quantityInMarket
WHERE
  _id = input__id;
END
/*update supplier*/
CREATE PROCEDURE `update_supplier`(
  input_id VARCHAR(10),
  input_s_name VARCHAR(10),
  input_s_email VARCHAR(50)
) BEGIN
UPDATE
  suppliers
SET
  s_name = input_s_name,
  s_email = input_s_email
WHERE
  supllier_id = input_id;
END
/*update supplier phone*/
CREATE PROCEDURE `update_supplier_phone`(
  input_id VARCHAR(10),
  input_old_phone VARCHAR(14),
  input_phone VARCHAR(14)
) BEGIN
UPDATE
  supplier_phone
SET
  phone = input_phone
WHERE
  _id = input_id
  and phone = input_old_phone;
DELETE FROM
  supplier_phone
WHERE
  phone = '';
END
/*Trigger to calculate out com*/
CREATE TRIGGER calculate_outcom
After
UPDATE
  ON total_price_recipt FOR EACH ROW BEGIN IF (new.r_Type = "sales") then
INSERT INTO
  outCome
VALUES(
    0,
    new.total_price,
    new.total_profits,
    MONTHNAME(NOW())
  ) ON DUPLICATE KEY
UPDATE
  sales = sales + new.total_price,
  total_profits = total_profits + new.total_profits;
  ELSE
INSERT INTO
  outCome
VALUES(
    new.total_price,
    0,
    new.total_profits,
    MONTHNAME(NOW())
  ) ON DUPLICATE KEY
UPDATE
  purchases = purchases + new.total_price,
  total_profits = total_profits + new.total_profits;
END IF;
END;
