-- Gameshelf: jogos de exemplo (os mesmos que estavam fixos no HTML da home).
-- A coluna "capa" fica vazia de propósito: coloque as imagens em uploads/capas/
-- e preencha com o nome do arquivo, por exemplo:
--   UPDATE jogos SET capa = 'elden-ring.jpg' WHERE titulo = 'Elden Ring';
-- (também aceita um link http/https completo)
-- Plataformas ficam separadas por vírgula, sem espaço: PC,PS,Xbox

INSERT INTO jogos (titulo, plataforma, genero, desenvolvedora, lancamento, descricao, nota, qtd_avaliacoes, idade, preco, preco_original, estoque, destaque, vendas) VALUES
('Elden Ring', 'PC,PS,Xbox', 'RPG', 'FromSoftware', '2022-02-25',
 'Explore as Terras Intermédias em um RPG de ação de mundo aberto criado em parceria com George R. R. Martin.',
 4.9, 12400, 16, 199.90, 249.90, 999, FALSE, 9800),
('Hogwarts Legacy', 'PC,PS,Xbox', 'RPG', 'Avalanche Software', '2023-02-10',
 'Viva sua própria história como estudante de Hogwarts no século XIX e descubra um segredo que ameaça o mundo bruxo.',
 4.7, 8900, 16, 179.90, 229.90, 999, FALSE, 8200),
('Red Dead Redemption 2', 'PC,PS,Xbox', 'Ação/Aventura', 'Rockstar Games', '2018-10-26',
 'Arthur Morgan e a gangue Van der Linde tentam sobreviver no fim do Velho Oeste.',
 4.8, 15200, 18, 149.90, 199.90, 999, FALSE, 9100),
('God of War Ragnarök', 'PS', 'Ação', 'Santa Monica Studio', '2022-11-09',
 'Kratos e Atreus enfrentam o Fimbulvetr e os deuses nórdicos em uma jornada pelos nove reinos.',
 4.9, 10700, 18, 199.90, 249.90, 999, FALSE, 8700),
('The Last of Us Part I', 'PS', 'Ação/Aventura', 'Naughty Dog', '2022-09-02',
 'Joel e Ellie atravessam os Estados Unidos devastados por uma infecção em uma das histórias mais marcantes dos games.',
 4.8, 13600, 18, 189.90, 239.90, 999, FALSE, 7600),
('Starfield', 'PC,Xbox', 'RPG', 'Bethesda Game Studios', '2023-09-06',
 'O primeiro universo novo da Bethesda em 25 anos: explore centenas de planetas à frente da Constelação.',
 4.5, 3200, 16, 249.90, NULL, 999, FALSE, 3100),
('Forza Motorsport', 'PC,Xbox', 'Corrida', 'Turn 10 Studios', '2023-10-10',
 'Simulador de corrida com pistas reconstruídas e física renovada.',
 4.7, 2800, 0, 299.90, NULL, 999, FALSE, 2400),
('Baldur''s Gate 3', 'PC,PS', 'RPG', 'Larian Studios', '2023-08-03',
 'Reúna seu grupo e enfrente o Devorador de Mentes em um RPG baseado em Dungeons & Dragons.',
 4.9, 25400, 18, 249.90, NULL, 999, FALSE, 6500),
('Marvel''s Spider-Man 2', 'PS', 'Ação', 'Insomniac Games', '2023-10-20',
 'Peter Parker e Miles Morales enfrentam Venom e Kraven em uma Nova York ainda maior.',
 4.8, 18700, 16, 299.90, NULL, 999, FALSE, 4800),
('Alan Wake 2', 'PC,PS', 'Terror', 'Remedy Entertainment', '2023-10-27',
 'Um thriller de terror psicológico em que Saga Anderson e Alan Wake investigam uma série de crimes rituais.',
 4.6, 9100, 18, 249.90, NULL, 999, FALSE, 2900),
('Sekiro: Shadows Die Twice', 'PC,PS,Xbox', 'Ação', 'FromSoftware', '2019-03-22',
 'Um shinobi sem um braço parte em busca de vingança no Japão feudal, onde a morte é só mais um recurso.',
 4.8, 9800, 16, 169.90, 199.90, 999, TRUE, 5200);
