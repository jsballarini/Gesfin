USE gesfin;

-- User: admin / Password: password
INSERT INTO users (username, password_hash, created_at, updated_at) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Initial Categories
INSERT INTO categories (name, type, is_active, created_at, updated_at) VALUES 
('Salário', 'income', 1, NOW(), NOW()),
('Freela', 'income', 1, NOW(), NOW()),
('Outros Recebimentos', 'income', 1, NOW(), NOW()),
('Aluguel', 'expense', 1, NOW(), NOW()),
('Energia', 'expense', 1, NOW(), NOW()),
('Internet', 'expense', 1, NOW(), NOW()),
('Mercado', 'expense', 1, NOW(), NOW()),
('Transporte', 'expense', 1, NOW(), NOW()),
('Outros Gastos', 'expense', 1, NOW(), NOW());