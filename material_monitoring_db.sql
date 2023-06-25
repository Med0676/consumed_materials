-- Create materials table
CREATE TABLE materials (
  material_id INT AUTO_INCREMENT PRIMARY KEY,
  material_name VARCHAR(100) NOT NULL,
  quantity INT DEFAULT 0
);

-- Create consumed_materials table
CREATE TABLE consumed_materials (
  consumed_id INT AUTO_INCREMENT PRIMARY KEY,
  material_id INT NOT NULL,
  quantity_consumed INT DEFAULT 0,
  date_consumed DATE NOT NULL,
  FOREIGN KEY (material_id) REFERENCES materials(material_id)
);
