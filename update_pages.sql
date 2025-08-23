INSERT INTO pages (title, slug, content, status, show_in_menu, menu_order, user_id, created_at, updated_at) VALUES
('Beranda', 'beranda', '<h1>Selamat Datang di Universitas Go-Campus</h1><p>Universitas terdepan dalam teknologi dan inovasi.</p>', 'published', 1, 1, 1, NOW(), NOW()),
('Tentang Kami', 'tentang-kami', '<h2>Tentang Universitas Go-Campus</h2><p>Universitas yang berdedikasi untuk memberikan pendidikan berkualitas.</p>', 'published', 1, 2, 1, NOW(), NOW()),
('Kontak', 'kontak', '<h2>Hubungi Kami</h2><p>Alamat: Jl. Contoh No. 123, Jakarta</p><p>Telepon: (021) 123-4567</p>', 'published', 1, 3, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE 
status = VALUES(status), 
show_in_menu = VALUES(show_in_menu),
updated_at = NOW();
