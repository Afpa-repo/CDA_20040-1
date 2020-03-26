#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP DATABASE IF EXISTS `e-gole`;
CREATE DATABASE `e-gole`;
USE `e-gole`;

#------------------------------------------------------------
# Table: Suppliers
#------------------------------------------------------------

CREATE TABLE Suppliers(
        IDSuppliers Int  Auto_increment  NOT NULL ,
        Company_Name Varchar (500) NOT NULL ,
        Headquarters Varchar (200) NOT NULL ,
        Tel          Varchar (15) NOT NULL ,
        City         Varchar (150) ,
        Mail         Varchar (150)
	,CONSTRAINT Suppliers_PK PRIMARY KEY (IDSuppliers)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commercial
#------------------------------------------------------------

CREATE TABLE Commercial(
        IDEmployees Int  Auto_increment  NOT NULL ,
        Name         Varchar (150) NOT NULL ,
        Surname      Varchar (150) NOT NULL ,
        Tel          Varchar (15) NOT NULL ,
        City         Varchar (100) NOT NULL ,
        mail         Varchar (150) NOT NULL ,
        Login        Varchar (100) NOT NULL ,
        Password     Varchar (150) NOT NULL
	,CONSTRAINT Commercial_PK PRIMARY KEY (IDEmployees)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Customers
#------------------------------------------------------------

CREATE TABLE Customers(
        IDCustomers     Int  Auto_increment  NOT NULL ,
        Delivery_Address Varchar (200) NOT NULL ,
        tel              Varchar (15) NOT NULL ,
        mail             Varchar (200) NOT NULL ,
        city             Varchar (150) NOT NULL
	,CONSTRAINT Customers_PK PRIMARY KEY (IDCustomers)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Orders
#------------------------------------------------------------

CREATE TABLE Orders(
        IDOrders        Int  Auto_increment  NOT NULL ,
        Delivery_Address Varchar (500) NOT NULL ,
        Order_date       Date NOT NULL ,
        Delivery_Date    Date NOT NULL ,
        Status           Varchar (150) NOT NULL ,
        Shipping_Price   DECIMAL (15,3)  NOT NULL ,
        IDEmployees     Int NOT NULL,
        IDCustomers     Int NOT NULL ,
	CONSTRAINT Orders_PK PRIMARY KEY (IDOrders),

	CONSTRAINT Orders_Commercial_FK FOREIGN KEY (IDEmployees) REFERENCES Commercial(IDEmployees),
	CONSTRAINT Orders_CUSTOMERS_FK FOREIGN KEY (IDCustomers) REFERENCES Customers(IDCustomers)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Manager
#------------------------------------------------------------

CREATE TABLE Manager(
        IDEmployees Int  Auto_increment  NOT NULL ,
        Name         Varchar (150) NOT NULL ,
        Surname      Varchar (150) NOT NULL ,
        Tel          Varchar (15) NOT NULL ,
        City         Varchar (100) NOT NULL ,
        mail         Varchar (150) NOT NULL ,
        Login        Varchar (100) NOT NULL ,
        Password     Varchar (150) NOT NULL
	,CONSTRAINT Manager_PK PRIMARY KEY (IDEmployees)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Products
#------------------------------------------------------------

CREATE TABLE Products(
        IDProducts         Int  Auto_increment  NOT NULL ,
        wording           Varchar (150) ,
        `references`        Varchar (25) ,
        price             DECIMAL (15,3)  ,
        Suppliers_Wording Varchar (25) NOT NULL ,
        Theme             Varchar (100) NOT NULL ,
        categorie         Varchar (100) NOT NULL ,
        Age               Varchar (3) NOT NULL ,
        Description       Varchar (500) NOT NULL ,
        IDSuppliers      Int NOT NULL ,
        IDEmployees      Int NOT NULL
	,CONSTRAINT Products_PK PRIMARY KEY (IDProducts)

	,CONSTRAINT Products_Suppliers_FK FOREIGN KEY (IDSuppliers) REFERENCES Suppliers(IDSuppliers)
	,CONSTRAINT Products_Manager0_FK FOREIGN KEY (IDEmployees) REFERENCES Manager(IDEmployees)
)ENGINE=InnoDB;



#------------------------------------------------------------
# Table: Particular
#------------------------------------------------------------

CREATE TABLE Particular(
        IDCustomers     Int NOT NULL ,
        sex              Boolean NOT NULL ,
        `name`             Varchar (150) NOT NULL ,
        surname          Varchar (150) NOT NULL ,
        Delivery_Address Varchar (200) NOT NULL ,
        tel              Varchar (15) NOT NULL ,
        mail             Varchar (200) NOT NULL ,
        city             Varchar (150) NOT NULL
	,CONSTRAINT Particular_PK PRIMARY KEY (IDCustomers)

	,CONSTRAINT Particular_Customers_FK FOREIGN KEY (IDCustomers) REFERENCES Customers(IDCustomers)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Professionnal
#------------------------------------------------------------

CREATE TABLE Professionnal(
        IDCustomers     Int NOT NULL ,
        company_name     Varchar (50) ,
        headquarters     Varchar (200) ,
        Siret_number     Varchar (13) NOT NULL ,
        billing_adress   Varchar (200) NOT NULL ,
        Decade           Int NOT NULL ,
        Status_Payement  Varchar (150) NOT NULL ,
        Delivery_Address Varchar (200) NOT NULL ,
        tel              Varchar (15) NOT NULL ,
        mail             Varchar (200) NOT NULL ,
        city             Varchar (150) NOT NULL
	,CONSTRAINT Professionnal_PK PRIMARY KEY (IDCustomers)

	,CONSTRAINT Professionnal_Customers_FK FOREIGN KEY (IDCustomers) REFERENCES Customers(IDCustomers)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: CART
#------------------------------------------------------------

CREATE TABLE CART(
        IDProducts    Int NOT NULL ,
        IDOrders    Int NOT NULL ,
        Quantity     Int NOT NULL ,
        Total_Cost   DECIMAL (15,3)  NOT NULL,
	CONSTRAINT CART_PK PRIMARY KEY (IDProducts,IDOrders),
	CONSTRAINT CART_PRODUCTS_FK FOREIGN KEY (IDProducts) REFERENCES Products(IDProducts),
	CONSTRAINT CART_ORDERS_FK FOREIGN KEY (IDOrders) REFERENCES Orders(IDOrders))

