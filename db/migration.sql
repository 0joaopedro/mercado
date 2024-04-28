CREATE TABLE IF NOT EXISTS product_type (
  id SERIAL NOT NULL PRIMARY KEY,
  name character varying(50) COLLATE pg_catalog."default" NOT NULL
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS product_type OWNER to postgres;

CREATE TABLE IF NOT EXISTS product (
  id SERIAL NOT NULL PRIMARY KEY,
  id_product_type integer NOT NULL,
  name character varying(50) COLLATE pg_catalog."default" NOT NULL,
  value numeric(10, 2) NOT NULL,
  CONSTRAINT product_product_type FOREIGN KEY (id_product_type) REFERENCES product_type (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS product OWNER to postgres;

CREATE TABLE IF NOT EXISTS tax (
  id SERIAL NOT NULL PRIMARY KEY,
  name character varying(50) COLLATE pg_catalog."default" NOT NULL,
  value numeric(5, 2)
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS tax OWNER to postgres;

CREATE TABLE IF NOT EXISTS tax_product_type (
  id_product_type integer NOT NULL,
  id_tax integer NOT NULL,
  CONSTRAINT tax_product_type_pkey PRIMARY KEY (id_product_type, id_tax),
  CONSTRAINT tax_product_type_id_product_fkey FOREIGN KEY (id_product_type) REFERENCES product_type (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT tax_product_type_id_tax_fkey FOREIGN KEY (id_tax) REFERENCES tax (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS tax_product_type OWNER to postgres;

CREATE TABLE IF NOT EXISTS checkout (
  id SERIAL NOT NULL PRIMARY KEY,
  value numeric(10, 2),
  value_tax numeric(10, 2)
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS checkout_product OWNER to postgres;

CREATE TABLE IF NOT EXISTS checkout_product (
  id SERIAL NOT NULL PRIMARY KEY,
  id_checkout integer NOT NULL,
  quantity integer NOT NULL,
  value numeric(10, 2),
  id_product integer NOT NULL,
  CONSTRAINT checkout_product_id_checkout_fkey FOREIGN KEY (id_checkout) REFERENCES checkout (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_product_checkout_product FOREIGN KEY (id_product) REFERENCES product (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS checkout_product OWNER to postgres;

CREATE TABLE IF NOT EXISTS checkout_product_tax (
  id SERIAL NOT NULL PRIMARY KEY,
  id_checkout_product integer NOT NULL,
  id_tax integer NOT NULL,
  value numeric(10, 2),
  CONSTRAINT checkout_product_tax_id_checkout_product_fkey FOREIGN KEY (id_checkout_product) REFERENCES checkout_product (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT checkout_product_tax_id_tax_fkey FOREIGN KEY (id_tax) REFERENCES tax (id) MATCH SIMPLE ON UPDATE CASCADE ON DELETE CASCADE
) TABLESPACE pg_default;

ALTER TABLE
  IF EXISTS checkout_product_tax OWNER to postgres;