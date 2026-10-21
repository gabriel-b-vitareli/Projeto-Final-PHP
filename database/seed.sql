-- Gameshelf: jogos de exemplo (17 jogos).
--
-- Imagens: cada jogo já aponta para uma capa, uma logo e um banner PADRÃO, que
-- vêm junto com o repositório (o Git guarda só os arquivos com prefixo "padrao-").
-- O nome segue sempre o mesmo formato, com o "slug" do jogo (ex.: helldivers-2):
--   capa   -> uploads/capas/padrao-<slug>.jpg
--   banner -> uploads/heros/padrao-<slug>.jpg
--   logo   -> uploads/logos/padrao-<slug>.png
-- A lista completa está em documentacao/imagens-padrao.md.
-- Pelo painel (Gerenciar jogos > Editar) dá para trocar qualquer imagem sem SQL;
-- as imagens padrão nunca são apagadas do disco por esse painel.
--
-- Destaque da página inicial: Helldivers 2 (único jogo com destaque = TRUE).
-- Plataformas ficam separadas por vírgula, sem espaço: PC,PS,Xbox
--
-- Para virar administrador (acesso a "Gerenciar jogos"), crie uma conta pelo
-- site e rode:
--   UPDATE usuarios SET nivel = 1 WHERE usuario = 'seu_usuario';

INSERT INTO jogos (titulo, plataforma, genero, desenvolvedora, lancamento, descricao, idade, preco, preco_original, destaque, capa, logo, hero) VALUES
('Helldivers 2', 'PC,PS', 'Tiro', 'Arrowhead Game Studios', '2024-02-08',
 'Alistem-se na Super Terra e levem a democracia gerenciada a planetas hostis neste tiro cooperativo de até quatro jogadores, com fogo amigo e muito caos.',
 16, 189.90, 229.90, TRUE,
 'padrao-helldivers-2.jpg', 'padrao-helldivers-2.png', 'padrao-helldivers-2.jpg'),
('Elden Ring', 'PC,PS,Xbox', 'RPG', 'FromSoftware', '2022-02-25',
 'Explore as Terras Intermédias em um RPG de ação de mundo aberto criado em parceria com George R. R. Martin.',
 16, 199.90, 249.90, FALSE,
 'padrao-elden-ring.jpg', 'padrao-elden-ring.png', 'padrao-elden-ring.jpg'),
('Hogwarts Legacy', 'PC,PS,Xbox', 'RPG', 'Avalanche Software', '2023-02-10',
 'Viva sua própria história como estudante de Hogwarts no século XIX e descubra um segredo que ameaça o mundo bruxo.',
 16, 179.90, 229.90, FALSE,
 'padrao-hogwarts-legacy.jpg', 'padrao-hogwarts-legacy.png', 'padrao-hogwarts-legacy.jpg'),
('Red Dead Redemption 2', 'PC,PS,Xbox', 'Ação/Aventura', 'Rockstar Games', '2018-10-26',
 'Arthur Morgan e a gangue Van der Linde tentam sobreviver no fim do Velho Oeste.',
 18, 149.90, 199.90, FALSE,
 'padrao-red-dead-redemption-2.jpg', 'padrao-red-dead-redemption-2.png', 'padrao-red-dead-redemption-2.jpg'),
('God of War Ragnarök', 'PS', 'Ação', 'Santa Monica Studio', '2022-11-09',
 'Kratos e Atreus enfrentam o Fimbulvetr e os deuses nórdicos em uma jornada pelos nove reinos.',
 18, 199.90, 249.90, FALSE,
 'padrao-god-of-war-ragnarok.jpg', 'padrao-god-of-war-ragnarok.png', 'padrao-god-of-war-ragnarok.jpg'),
('The Last of Us Part I', 'PS', 'Ação/Aventura', 'Naughty Dog', '2022-09-02',
 'Joel e Ellie atravessam os Estados Unidos devastados por uma infecção em uma das histórias mais marcantes dos games.',
 18, 189.90, 239.90, FALSE,
 'padrao-the-last-of-us-part-i.jpg', 'padrao-the-last-of-us-part-i.png', 'padrao-the-last-of-us-part-i.jpg'),
('Starfield', 'PC,Xbox', 'RPG', 'Bethesda Game Studios', '2023-09-06',
 'O primeiro universo novo da Bethesda em 25 anos: explore centenas de planetas à frente da Constelação.',
 16, 249.90, NULL, FALSE,
 'padrao-starfield.jpg', 'padrao-starfield.png', 'padrao-starfield.jpg'),
('Forza Motorsport', 'PC,Xbox', 'Corrida', 'Turn 10 Studios', '2023-10-10',
 'Simulador de corrida com pistas reconstruídas e física renovada.',
 0, 299.90, NULL, FALSE,
 'padrao-forza-motorsport.jpg', 'padrao-forza-motorsport.png', 'padrao-forza-motorsport.jpg'),
('Baldur''s Gate 3', 'PC,PS', 'RPG', 'Larian Studios', '2023-08-03',
 'Reúna seu grupo e enfrente o Devorador de Mentes em um RPG baseado em Dungeons & Dragons.',
 18, 249.90, NULL, FALSE,
 'padrao-baldurs-gate-3.jpg', 'padrao-baldurs-gate-3.png', 'padrao-baldurs-gate-3.jpg'),
('Marvel''s Spider-Man 2', 'PS', 'Ação', 'Insomniac Games', '2023-10-20',
 'Peter Parker e Miles Morales enfrentam Venom e Kraven em uma Nova York ainda maior.',
 16, 299.90, NULL, FALSE,
 'padrao-marvels-spider-man-2.jpg', 'padrao-marvels-spider-man-2.png', 'padrao-marvels-spider-man-2.jpg'),
('Alan Wake 2', 'PC,PS', 'Terror', 'Remedy Entertainment', '2023-10-27',
 'Um thriller de terror psicológico em que Saga Anderson e Alan Wake investigam uma série de crimes rituais.',
 18, 249.90, NULL, FALSE,
 'padrao-alan-wake-2.jpg', 'padrao-alan-wake-2.png', 'padrao-alan-wake-2.jpg'),
('Sekiro: Shadows Die Twice', 'PC,PS,Xbox', 'Ação', 'FromSoftware', '2019-03-22',
 'Um shinobi sem um braço parte em busca de vingança no Japão feudal, onde a morte é só mais um recurso.',
 16, 169.90, 199.90, FALSE,
 'padrao-sekiro.jpg', 'padrao-sekiro.png', 'padrao-sekiro.jpg'),
('Watch Dogs 2', 'PC,PS,Xbox', 'Ação/Aventura', 'Ubisoft Montreal', '2016-11-15',
 'Marcus Holloway se junta ao grupo hacker DedSec para derrubar um sistema de vigilância que controla a Baía de São Francisco.',
 18, 59.90, 149.90, FALSE,
 'padrao-watch-dogs-2.jpg', 'padrao-watch-dogs-2.png', 'padrao-watch-dogs-2.jpg'),
('Hollow Knight', 'PC,PS,Xbox,Switch', 'Metroidvania', 'Team Cherry', '2017-02-24',
 'Desça às profundezas de Hallownest, um reino de insetos em ruínas, em uma aventura de ação desenhada à mão.',
 10, 36.99, 46.99, FALSE,
 'padrao-hollow-knight.jpg', 'padrao-hollow-knight.png', 'padrao-hollow-knight.jpg'),
('Hollow Knight: Silksong', 'PC,PS,Xbox,Switch', 'Metroidvania', 'Team Cherry', '2025-09-04',
 'Como Hornet, a princesa-protetora de Hallownest, suba ao reino de Pharloom em uma aventura ágil, cheia de chefes e segredos.',
 10, 59.99, NULL, FALSE,
 'padrao-hollow-knight-silksong.jpg', 'padrao-hollow-knight-silksong.png', 'padrao-hollow-knight-silksong.jpg'),
('Grand Theft Auto V', 'PC,PS,Xbox', 'Ação/Aventura', 'Rockstar North', '2013-09-17',
 'Três criminosos tentam o golpe perfeito em Los Santos, em um mundo aberto cheio de missões, dinheiro e confusão.',
 18, 79.90, 129.90, FALSE,
 'padrao-gta-5.jpg', 'padrao-gta-5.png', 'padrao-gta-5.jpg'),
('EA Sports FC 26', 'PC,PS,Xbox,Switch', 'Esporte', 'EA Vancouver', '2026-09-25',
 'A nova temporada do futebol da EA: Ultimate Team, Modo Carreira. Novos modos, novas ligas, novos times e novos jogadores.',
 0, 299.90, NULL, FALSE,
 'padrao-ea-fc-26.jpg', 'padrao-ea-fc-26.png', 'padrao-ea-fc-26.jpg');
