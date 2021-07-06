INSERT INTO user_type 
	(name) 
VALUES 
	("customer"), 
	("admin"), 
    ("employee");
-- SELECT * FROM user_type;

SELECT (count(*)) FROM user;

INSERT INTO payment_method 
	(name) 
VALUES
	("cash"),
    ("credit card");
    
INSERT INTO provider
	(name)
VALUES
	("compra certa");

INSERT INTO compracertadb.user
	(email, user_type,  first_name, last_name, phone, cpf, password)
VALUES
	("admin@mail.com", "admin", "admin", "admin", "+8466983153221", "9999999999999", "minhasenha");
INSERT INTO compracertadb.admin
		(user_id, expire_at)
	VALUES
		(last_insert_id(), "2021-12-31 23:59:59.999999");


INSERT INTO compracertadb.user
	(email, user_type, first_name, last_name, phone, cpf, password)
VALUES
	("empone@mail.com", "employee", "employee1", "firstone", "+8466983153221", "9999999999999", "minhasenha");
        
INSERT INTO compracertadb.employee
	(user_id, hired_at)
VALUES
	(last_insert_id(), NOW());


INSERT INTO compracertadb.user
	(email, user_type, first_name, last_name, phone, cpf, password)
VALUES
	("emptwo@mail.com", "employee", "employee2", "secondone", "+8466983153221", "9999999999999", "minhasenha");
	
INSERT INTO compracertadb.employee
	(user_id, hired_at)
VALUES
	(last_insert_id(), NOW());

DELETE FROM provider WHERE id != 0;
ALTER TABLE provider AUTO_INCREMENT = 1;
INSERT INTO compracertadb.provider
	(name)
VALUES
	("Compra Certa");


ALTER TABLE price_history ADD COLUMN active TINYINT NOT NULL DEFAULT 1;

ALTER TABLE product DROP CONSTRAINT fk_Product_price_history1;
ALTER TABLE product DROP COLUMN active_price_id;


INSERT INTO product_type
	(name)
VALUES
	("informática"),
    ("eletrodoméstico"),
    ("livro"),
    ("cama, mesa e banho"),
    ("móvel"),
    ("tv e vídeo");


SELECT * FROM product_type;

SELECT * FROM price_history;

SELECT * FROM media;
SELECT * FROM product
	JOIN price_history
		ON price_history.product_id = product.id AND active = 1
	LEFT OUTER JOIN media
		ON media.product_id = product.id AND main = 1
;
SELECT * FROM media;
SELECT * FROM product;

SELECT * FROM product
JOIN media ON media.product_id = product.id AND media.main = 1;
SELECT * FROM media JOIN product ON media.product_id = product.id;

ALTER TABLE media MODIFY COLUMN path VARCHAR(256) NOT NULL;

DELETE FROM media WHERE media.path != "";

DROP TABLE media;

CREATE TABLE media (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id INT UNSIGNED NOT NULL,
    path VARCHAR(256) NOT NULL,
    ext VARCHAR(16) NOT NULL,
    main TINYINT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES product (id)
    ON DELETE NO ACTION ON UPDATE NO ACTION
);

INSERT INTO price_history
	(product_id, value, divided_max, payment_discount)
VALUES
	(1, 10000, 10, 100);

SELECT 	p.id, p.name, p.rating, p.product_type_id, p.description,
		p.stock, p.provider_id, p.sold_qnt,
		m.path, m.ext, m.main
FROM product as p
	LEFT OUTER JOIN media as m
		ON m.product_id = p.id AND m.main = 1;

SELECT 	p.id, p.name, p.rating, p.product_type_id, p.description,
		p.stock, p.provider_id, p.sold_qnt,
		ph.value, ph.divided_max, ph.payment_discount, ph.active,
		m.path, m.ext, m.main
FROM product as p
	LEFT OUTER JOIN media as m
		ON m.product_id = p.id AND m.main = 1
	LEFT JOIN price_history as ph
		ON ph.product_id = p.id AND ph.active = 1
;

SELECT * FROM user ORDER BY id DESC;

DELETE FROM token WHERE id != 0;

SELECT * FROM product WHERE product.id IN (1,2,3,4);

            SELECT p.id, p.name, p.rating, p.product_type_id, p.description,
                   p.stock, p.provider_id, p.sold_qnt,
                   ph.value, ph.divided_max, ph.payment_discount, ph.active,
                   m.path, m.ext, m.main
                FROM product as p
                JOIN price_history as ph
                    ON ph.product_id = p.id AND ph.active = 1
                LEFT OUTER JOIN media as m
                    ON m.product_id = p.id AND m.main = 1
			WHERE p.id IN (1,2);
            
ALTER TABLE order_tracking DROP COLUMN id;
ALTER TABLE order_tracking ADD COLUMN id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT;
ALTER TABLE order_products ADD COLUMN qnt SMALLINT UNSIGNED NOT NULL DEFAULT 1;

ALTER TABLE order_products RENAME COLUMN rating TO op_rating;