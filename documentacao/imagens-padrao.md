# Imagens padrão dos jogos de exemplo

O `database/seed.sql` cadastra 17 jogos e cada um já aponta para três imagens **padrão**: capa, banner e logo. Os arquivos ficam no repositório, nas mesmas pastas dos uploads do painel, e são reconhecidos pelo prefixo `padrao-`.

## Como funciona

| Imagem | Pasta | Nome do arquivo | Formato | Tamanho sugerido |
|---|---|---|---|---|
| Capa | `uploads/capas/` | `padrao-<slug>.jpg` | JPG | vertical, cerca de 600 x 900 px |
| Banner | `uploads/heros/` | `padrao-<slug>.jpg` | JPG | horizontal, cerca de 1920 x 620 px |
| Logo | `uploads/logos/` | `padrao-<slug>.png` | PNG com fundo transparente | cerca de 600 px de largura |

- O `<slug>` é o nome do jogo em minúsculas e com hífens (veja a tabela abaixo).
- O Git ignora tudo o que o painel enviar (nomes aleatórios), mas **guarda** os arquivos que começam com `padrao-`. A regra está em `uploads/.gitignore`.
- O painel de administração **nunca apaga** uma imagem `padrao-*` do disco, nem ao excluir o jogo nem ao trocar a imagem dele. Assim, as imagens do repositório não somem por acidente.
- Se preferir outro formato (por exemplo, capas em `.webp`), renomeie os arquivos e ajuste as extensões em `database/seed.sql` antes de rodá-lo.
- A logo e o banner só aparecem no **destaque da página inicial** (hoje, o Helldivers 2). Os outros jogos só passam a mostrá-los se um administrador marcar um deles como destaque.

## Lista de arquivos

Marque conforme for adicionando:

| Jogo | Capa (`capas/`) | Banner (`heros/`) | Logo (`logos/`) |
|---|---|---|---|
| Helldivers 2 | `padrao-helldivers-2.jpg` | `padrao-helldivers-2.jpg` | `padrao-helldivers-2.png` |
| Elden Ring | `padrao-elden-ring.jpg` | `padrao-elden-ring.jpg` | `padrao-elden-ring.png` |
| Hogwarts Legacy | `padrao-hogwarts-legacy.jpg` | `padrao-hogwarts-legacy.jpg` | `padrao-hogwarts-legacy.png` |
| Red Dead Redemption 2 | `padrao-red-dead-redemption-2.jpg` | `padrao-red-dead-redemption-2.jpg` | `padrao-red-dead-redemption-2.png` |
| God of War Ragnarök | `padrao-god-of-war-ragnarok.jpg` | `padrao-god-of-war-ragnarok.jpg` | `padrao-god-of-war-ragnarok.png` |
| The Last of Us Part I | `padrao-the-last-of-us-part-i.jpg` | `padrao-the-last-of-us-part-i.jpg` | `padrao-the-last-of-us-part-i.png` |
| Starfield | `padrao-starfield.jpg` | `padrao-starfield.jpg` | `padrao-starfield.png` |
| Forza Motorsport | `padrao-forza-motorsport.jpg` | `padrao-forza-motorsport.jpg` | `padrao-forza-motorsport.png` |
| Baldur's Gate 3 | `padrao-baldurs-gate-3.jpg` | `padrao-baldurs-gate-3.jpg` | `padrao-baldurs-gate-3.png` |
| Marvel's Spider-Man 2 | `padrao-marvels-spider-man-2.jpg` | `padrao-marvels-spider-man-2.jpg` | `padrao-marvels-spider-man-2.png` |
| Alan Wake 2 | `padrao-alan-wake-2.jpg` | `padrao-alan-wake-2.jpg` | `padrao-alan-wake-2.png` |
| Sekiro: Shadows Die Twice | `padrao-sekiro.jpg` | `padrao-sekiro.jpg` | `padrao-sekiro.png` |
| Watch Dogs 2 | `padrao-watch-dogs-2.jpg` | `padrao-watch-dogs-2.jpg` | `padrao-watch-dogs-2.png` |
| Hollow Knight | `padrao-hollow-knight.jpg` | `padrao-hollow-knight.jpg` | `padrao-hollow-knight.png` |
| Hollow Knight: Silksong | `padrao-hollow-knight-silksong.jpg` | `padrao-hollow-knight-silksong.jpg` | `padrao-hollow-knight-silksong.png` |
| Grand Theft Auto V | `padrao-gta-5.jpg` | `padrao-gta-5.jpg` | `padrao-gta-5.png` |
| EA Sports FC 27 | `padrao-ea-fc-27.jpg` | `padrao-ea-fc-27.jpg` | `padrao-ea-fc-27.png` |

## Conferir o que falta

Na raiz do projeto, no Linux, macOS ou Git Bash:

```bash
for s in helldivers-2 elden-ring hogwarts-legacy red-dead-redemption-2 god-of-war-ragnarok the-last-of-us-part-i starfield forza-motorsport baldurs-gate-3 marvels-spider-man-2 alan-wake-2 sekiro watch-dogs-2 hollow-knight hollow-knight-silksong gta-5 ea-fc-27; do
  for f in capas/padrao-$s.jpg heros/padrao-$s.jpg logos/padrao-$s.png; do
    [ -f "uploads/$f" ] || echo "falta: uploads/$f"
  done
done
```

Sem nenhuma linha de saída, está tudo no lugar.
