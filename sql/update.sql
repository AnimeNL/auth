# Add a unique primary key to the visitor rights, or doctrine cannot differentiate on join
ALTER TABLE jpop__visitor_rights MODIFY vir_id_visitor bigint unsigned not null;
ALTER TABLE jpop__visitor_rights DROP PRIMARY KEY;
ALTER TABLE jpop__visitor_rights ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE jpop__visitor_rights ADD CONSTRAINT UNIQUE (`vir_id_visitor`, `vir_right`);

# Rename event and cms permissions
UPDATE jpop__visitor_rights SET vir_right = 'events.read' WHERE vir_right = 'Events';
UPDATE jpop__visitor_rights SET vir_right = 'events.setup' WHERE vir_right = 'Event Setup';
UPDATE jpop__visitor_rights SET vir_right = 'events.edit' WHERE vir_right = 'Event Edit';
UPDATE jpop__visitor_rights SET vir_right = 'events.create' WHERE vir_right = 'Event Create';
UPDATE jpop__visitor_rights SET vir_right = 'cms' WHERE vir_right = 'Articles';