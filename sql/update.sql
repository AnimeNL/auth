# Add a unique primary key to the visitor rights, or doctrine cannot differentiate on join
ALTER TABLE jpop__visitor_rights MODIFY vir_id_visitor bigint unsigned not null;
ALTER TABLE jpop__visitor_rights DROP PRIMARY KEY;
ALTER TABLE jpop__visitor_rights ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE jpop__visitor_rights ADD CONSTRAINT UNIQUE (`vir_id_visitor`, `vir_right`);
