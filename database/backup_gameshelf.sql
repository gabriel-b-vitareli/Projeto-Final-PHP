--
-- PostgreSQL database dump
--

\restrict DhHKtBB7NmcqUTH6lD6iKDGXwuPcuaWV3MN1oxTBC1NpSJZa3qjefTgFlEaVNb1

-- Dumped from database version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)

-- Started on 2026-10-20 16:55:08 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 32832)
-- Name: carrinho; Type: TABLE; Schema: public; Owner: gameshelf
--

CREATE TABLE public.carrinho (
    usuario_id integer NOT NULL,
    jogo_id integer NOT NULL,
    criado_em timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.carrinho OWNER TO gameshelf;

--
-- TOC entry 223 (class 1259 OID 32814)
-- Name: favoritos; Type: TABLE; Schema: public; Owner: gameshelf
--

CREATE TABLE public.favoritos (
    usuario_id integer NOT NULL,
    jogo_id integer NOT NULL,
    criado_em timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.favoritos OWNER TO gameshelf;

--
-- TOC entry 222 (class 1259 OID 32773)
-- Name: jogos; Type: TABLE; Schema: public; Owner: gameshelf
--

CREATE TABLE public.jogos (
    id integer NOT NULL,
    titulo character varying(100) NOT NULL,
    capa character varying(500),
    plataforma character varying(100),
    genero character varying(50),
    desenvolvedora character varying(100),
    lancamento date NOT NULL,
    descricao text,
    nota numeric(3,1),
    idade integer,
    preco numeric(10,2) NOT NULL,
    estoque integer DEFAULT 0,
    destaque boolean DEFAULT false,
    preco_original numeric(10,2),
    qtd_avaliacoes integer DEFAULT 0,
    vendas integer DEFAULT 0,
    logo character varying(500),
    hero character varying(500)
);


ALTER TABLE public.jogos OWNER TO gameshelf;

--
-- TOC entry 221 (class 1259 OID 32772)
-- Name: jogos_id_seq; Type: SEQUENCE; Schema: public; Owner: gameshelf
--

CREATE SEQUENCE public.jogos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jogos_id_seq OWNER TO gameshelf;

--
-- TOC entry 3518 (class 0 OID 0)
-- Dependencies: 221
-- Name: jogos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gameshelf
--

ALTER SEQUENCE public.jogos_id_seq OWNED BY public.jogos.id;


--
-- TOC entry 220 (class 1259 OID 24783)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: gameshelf
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    usuario character varying(50) NOT NULL,
    senha character varying(255),
    nivel integer DEFAULT 0
);


ALTER TABLE public.usuarios OWNER TO gameshelf;

--
-- TOC entry 219 (class 1259 OID 24782)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: gameshelf
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO gameshelf;

--
-- TOC entry 3519 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gameshelf
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 3339 (class 2604 OID 32776)
-- Name: jogos id; Type: DEFAULT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.jogos ALTER COLUMN id SET DEFAULT nextval('public.jogos_id_seq'::regclass);


--
-- TOC entry 3337 (class 2604 OID 24786)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 3512 (class 0 OID 32832)
-- Dependencies: 224
-- Data for Name: carrinho; Type: TABLE DATA; Schema: public; Owner: gameshelf
--

COPY public.carrinho (usuario_id, jogo_id, criado_em) FROM stdin;
7	3	2026-10-20 08:20:40.248992
3	3	2026-10-20 13:40:55.299241
\.


--
-- TOC entry 3511 (class 0 OID 32814)
-- Dependencies: 223
-- Data for Name: favoritos; Type: TABLE DATA; Schema: public; Owner: gameshelf
--

COPY public.favoritos (usuario_id, jogo_id, criado_em) FROM stdin;
7	3	2026-10-20 08:58:20.961141
3	3	2026-10-20 13:40:50.22574
\.


--
-- TOC entry 3510 (class 0 OID 32773)
-- Dependencies: 222
-- Data for Name: jogos; Type: TABLE DATA; Schema: public; Owner: gameshelf
--

COPY public.jogos (id, titulo, capa, plataforma, genero, desenvolvedora, lancamento, descricao, nota, idade, preco, estoque, destaque, preco_original, qtd_avaliacoes, vendas, logo, hero) FROM stdin;
10	Forza Motorsport 6	52089ea28d466f5d.png	PC,Xbox	Corrida	Turn 10 Studios	2023-10-10	Simulador de corrida com pistas reconstruídas e física renovada.	4.7	0	299.90	999	f	\N	2800	2400	\N	\N
3	Helldivers 2	97823a2e777d84af.jpg	PC,PS,Xbox	Ação	Arrowhead	2024-02-08	"A última linha ofensiva da Galáxia. Aliste-se aos Helldivers e lute pela Liberdade numa galáxia hostil neste feroz, frenético e veloz jogo de tiro em terceira pessoa."	\N	18	150.00	0	t	200.00	0	0	bd1444360d9093e0.png	07f72a0a1c3fbb30.jpg
7	God of War Ragnarök	676c2f34a80f7e24.png	PS	Ação	Santa Monica Studio	2022-11-09	Kratos e Atreus enfrentam o Fimbulvetr e os deuses nórdicos em uma jornada pelos nove reinos.	4.9	18	199.90	999	f	249.90	10700	8700	\N	\N
12	Marvel's Spider-Man 2	a88446bf6cc3fa56.png	PS	Ação	Insomniac Games	2023-10-20	Peter Parker e Miles Morales enfrentam Venom e Kraven em uma Nova York ainda maior.	4.8	16	299.90	999	f	\N	18700	4800	\N	\N
5	Hogwarts Legacy	dac5da23e95e2662.webp	PC,PS,Xbox	RPG	Avalanche Software	2023-02-10	Viva sua própria história como estudante de Hogwarts no século XIX e descubra um segredo que ameaça o mundo bruxo.	4.7	16	179.90	999	f	229.90	8900	8200	\N	\N
13	Alan Wake 2	ef0a5b7dd01376b6.jpg	PC,PS	Terror	Remedy Entertainment	2023-10-27	Um thriller de terror psicológico em que Saga Anderson e Alan Wake investigam uma série de crimes rituais.	4.6	18	249.90	999	f	\N	9100	2900	2aac3c55112edb96.png	fa262e95a995bdeb.jpg
11	Baldur's Gate 3	4c458896494e735f.png	PC,PS	RPG	Larian Studios	2023-08-03	Reúna seu grupo e enfrente o Devorador de Mentes em um RPG baseado em Dungeons & Dragons.	4.9	18	249.90	999	f	\N	25400	6500	\N	\N
4	Elden Ring	02809d731909fc7d.png	PC,PS,Xbox	RPG	FromSoftware	2022-02-25	Explore as Terras Intermédias em um RPG de ação de mundo aberto criado em parceria com George R. R. Martin.	4.9	16	199.90	999	f	249.90	12400	9800	\N	\N
14	Sekiro: Shadows Die Twice	ef9cce978384d301.png	PC,PS,Xbox	Ação	FromSoftware	2019-03-22	Um shinobi sem um braço parte em busca de vingança no Japão feudal, onde a morte é só mais um recurso.	4.8	16	169.90	999	f	199.90	9800	5200	\N	\N
9	Starfield	3ddbb242f084d8cb.png	PC,Xbox	RPG	Bethesda Game Studios	2023-09-06	O primeiro universo novo da Bethesda em 25 anos: explore centenas de planetas à frente da Constelação.	4.5	16	249.90	999	f	\N	3200	3100	\N	\N
8	The Last of Us Part I	f005b0fd74af04d2.png	PS	Ação/Aventura	Naughty Dog	2022-09-02	Joel e Ellie atravessam os Estados Unidos devastados por uma infecção em uma das histórias mais marcantes dos games.	4.8	18	189.90	999	f	239.90	13600	7600	\N	\N
15	Crash of the titans	9863839b9d3da92c.png	PS	Ação/Aventura	Univali	2007-10-01	Crash of the Titans é um jogo eletrônico de ação e aventura desenvolvido pela Radical Entertainment e publicado pela Sierra Entertainment (e Vivendi Games) em 2007.	\N	0	20.00	0	f	35.00	0	0	\N	\N
6	Red Dead Redemption 2	f86a438bd53b0a01.png	PC,PS,Xbox	Ação/Aventura	Rockstar Games	2018-10-26	Arthur Morgan e a gangue Van der Linde tentam sobreviver no fim do Velho Oeste.	4.8	18	149.90	999	f	199.90	15200	9100	\N	\N
\.


--
-- TOC entry 3508 (class 0 OID 24783)
-- Dependencies: 220
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: gameshelf
--

COPY public.usuarios (id, usuario, senha, nivel) FROM stdin;
3	admin	$2y$12$XRreIiTanHtyol9kTwVY/.PAyVv09XuHVgXKCLBE7JXt/50gVzOou	1
1	adm	$2y$12$e9NOrpQpBbclOI.fP5sAr.mgjRdmtaIMqC.COmuIkVpUzacHafr4K	0
6	administrador	$2y$12$XTdOSa7C1JN.d7RSzIc0Z.9ZoSv0e..X7iHlLtuonyZqok71CQGZW	1
7	fachinello	$2y$12$S8jmLRGx.eCQ1ZYsAdj/mew5o/Jsf9.AIhlazkuaVXEialNT84ezi	0
\.


--
-- TOC entry 3520 (class 0 OID 0)
-- Dependencies: 221
-- Name: jogos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gameshelf
--

SELECT pg_catalog.setval('public.jogos_id_seq', 15, true);


--
-- TOC entry 3521 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gameshelf
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 7, true);


--
-- TOC entry 3355 (class 2606 OID 32839)
-- Name: carrinho carrinho_pkey; Type: CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT carrinho_pkey PRIMARY KEY (usuario_id, jogo_id);


--
-- TOC entry 3353 (class 2606 OID 32821)
-- Name: favoritos favoritos_pkey; Type: CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_pkey PRIMARY KEY (usuario_id, jogo_id);


--
-- TOC entry 3351 (class 2606 OID 32786)
-- Name: jogos jogos_pkey; Type: CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.jogos
    ADD CONSTRAINT jogos_pkey PRIMARY KEY (id);


--
-- TOC entry 3347 (class 2606 OID 24790)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 3349 (class 2606 OID 24792)
-- Name: usuarios usuarios_usuario_key; Type: CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_usuario_key UNIQUE (usuario);


--
-- TOC entry 3358 (class 2606 OID 32845)
-- Name: carrinho carrinho_jogo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT carrinho_jogo_id_fkey FOREIGN KEY (jogo_id) REFERENCES public.jogos(id) ON DELETE CASCADE;


--
-- TOC entry 3359 (class 2606 OID 32840)
-- Name: carrinho carrinho_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT carrinho_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;


--
-- TOC entry 3356 (class 2606 OID 32827)
-- Name: favoritos favoritos_jogo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_jogo_id_fkey FOREIGN KEY (jogo_id) REFERENCES public.jogos(id) ON DELETE CASCADE;


--
-- TOC entry 3357 (class 2606 OID 32822)
-- Name: favoritos favoritos_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gameshelf
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuarios(id) ON DELETE CASCADE;


-- Completed on 2026-10-20 16:55:13 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict DhHKtBB7NmcqUTH6lD6iKDGXwuPcuaWV3MN1oxTBC1NpSJZa3qjefTgFlEaVNb1

