--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying NOT NULL,
    password character varying NOT NULL,
    first_name character varying NOT NULL,
    last_name character varying NOT NULL,
    user_type character varying DEFAULT 'customer'::character varying NOT NULL,
    email character varying,
    creation_time timestamp without time zone,
    random_string character varying
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 66, true);


--
-- Name: customers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE customers (
    address character varying,
    postal_code character varying,
    phone character varying,
    birth_date date,
    activated boolean DEFAULT false NOT NULL
)
INHERITS (users);


ALTER TABLE public.customers OWNER TO postgres;

--
-- Name: news; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE news (
    id bigint NOT NULL,
    title character varying NOT NULL,
    content character varying,
    date timestamp without time zone
);


ALTER TABLE public.news OWNER TO postgres;

--
-- Name: news_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE news_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.news_id_seq OWNER TO postgres;

--
-- Name: news_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE news_id_seq OWNED BY news.id;


--
-- Name: news_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('news_id_seq', 1, false);


--
-- Name: posts_rss; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE posts_rss (
    id bigint NOT NULL,
    title character varying NOT NULL,
    text character varying NOT NULL,
    date date NOT NULL
);


ALTER TABLE public.posts_rss OWNER TO postgres;

--
-- Name: products; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE products (
    id integer NOT NULL,
    product_name character varying,
    seller_id integer,
    lower_limit integer,
    description character varying,
    image character varying,
    base_discount integer,
    price numeric(15,0),
    start_schedule date,
    start_time time without time zone,
    duration integer,
    CONSTRAINT check_base_discount_range CHECK (((base_discount >= 0) AND (base_discount <= 100)))
);


ALTER TABLE public.products OWNER TO postgres;

--
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.products_id_seq OWNER TO postgres;

--
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE products_id_seq OWNED BY products.id;


--
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('products_id_seq', 55, true);


--
-- Name: sellers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sellers (
    display_name character varying,
    address character varying,
    phone character varying,
    approved boolean DEFAULT false NOT NULL,
    map_location character varying
)
INHERITS (users);


ALTER TABLE public.sellers OWNER TO postgres;

--
-- Name: transactions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transactions (
    id bigint NOT NULL,
    user_id integer NOT NULL,
    product_id integer NOT NULL,
    count integer NOT NULL,
    transaction_time timestamp with time zone NOT NULL,
    buying_state integer DEFAULT 1 NOT NULL,
    pursuit_code character varying,
    delivered boolean DEFAULT false NOT NULL
);


ALTER TABLE public.transactions OWNER TO postgres;

--
-- Name: transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transactions_id_seq OWNER TO postgres;

--
-- Name: transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE transactions_id_seq OWNED BY transactions.id;


--
-- Name: transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('transactions_id_seq', 177, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE news ALTER COLUMN id SET DEFAULT nextval('news_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE products ALTER COLUMN id SET DEFAULT nextval('products_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE transactions ALTER COLUMN id SET DEFAULT nextval('transactions_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY customers (id, username, password, first_name, last_name, user_type, email, creation_time, random_string, address, postal_code, phone, birth_date, activated) FROM stdin;
60	customer_1	91ec1f9324753048c0096d036a694f86	صادق	کاظمی	customer	mail@gmail.com	2011-12-12 14:58:42	\N	تهران، خانه	9384282818	0	\N	t
61	customer_2	91ec1f9324753048c0096d036a694f86	صادق	کاظمی	customer	mail@gmail.com	2011-12-12 14:58:42	\N	تهران، خانه	9384282818	0	\N	t
62	customer_3	91ec1f9324753048c0096d036a694f86	صادق	کاظمی	customer	mail@gmail.com	2011-12-12 14:58:42	\N	تهران، خانه	9384282818	0	\N	t
63	customer_4	91ec1f9324753048c0096d036a694f86	صادق	کاظمی	customer	mail@gmail.com	2011-12-12 14:58:42	\N	تهران، خانه	9384282818	0	\N	t
65	customer_5	91ec1f9324753048c0096d036a694f86	صادق	کاظمی	customer	mail@gmail.com	2011-12-12 14:58:42	\N	تهران، خانه	9384282818	0	\N	t
66	customer_6	91ec1f9324753048c0096d036a694f86	صادق	کاظمی	customer	mail@gmail.com	2011-12-12 14:58:42	\N	تهران، خانه	9384282818	0	\N	t
\.


--
-- Data for Name: news; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY news (id, title, content, date) FROM stdin;
\.


--
-- Data for Name: posts_rss; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY posts_rss (id, title, text, date) FROM stdin;
54	نوت بوک MacBook Air 11.6	Processor and memory:\n- 1.6GHz dual-core Intel Core i5 with 3MB shared L3 cache\n- 2GB of 1333MHz DDR3 onboard memory\n\nStorage:\n- 64GB flash storage\n\nDisplay:\n- 11.6-inch (diagonal) high-resolution LED-backlit glossy widescreen display with support for millions of colors\n- Supported resolutions: 1366 by 768 (native), 1344 by 756, and 1280 by 720 pixels at 16:9 aspect ratio; 1152 by 720 and 1024 by 640 pixels at 16:10 aspect ratio; 1024 by 768 and 800 by 600 pixels at 4:3 aspect ratio	2011-12-12
55	تلفن همراه Xperia active	صفحه کلید: صفحه کلید لمسی\nسیستم عامل: Android\nحافظه داخلی: ‏RAM: 512MB\nInternal phone storage: 1GB (up to 320MB free)‎\nنوع کارت حافظه: microSD, up to 32GB\nدوربین: 5 تا 8 مگاپیکسل 	2011-12-12
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY products (id, product_name, seller_id, lower_limit, description, image, base_discount, price, start_schedule, start_time, duration) FROM stdin;
54	نوت بوک MacBook Air 11.6	56	20	Processor and memory:\n- 1.6GHz dual-core Intel Core i5 with 3MB shared L3 cache\n- 2GB of 1333MHz DDR3 onboard memory\n\nStorage:\n- 64GB flash storage\n\nDisplay:\n- 11.6-inch (diagonal) high-resolution LED-backlit glossy widescreen display with support for millions of colors\n- Supported resolutions: 1366 by 768 (native), 1344 by 756, and 1280 by 720 pixels at 16:9 aspect ratio; 1152 by 720 and 1024 by 640 pixels at 16:10 aspect ratio; 1024 by 768 and 800 by 600 pixels at 4:3 aspect ratio	pic1.jpg	35	178000000	2011-12-12	06:00:00	129600
55	تلفن همراه Xperia active	55	2	صفحه کلید: صفحه کلید لمسی\nسیستم عامل: Android\nحافظه داخلی: ‏RAM: 512MB\nInternal phone storage: 1GB (up to 320MB free)‎\nنوع کارت حافظه: microSD, up to 32GB\nدوربین: 5 تا 8 مگاپیکسل 	xperia1.jpg	40	4240000	2011-12-12	00:00:00	86400
\.


--
-- Data for Name: sellers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sellers (id, username, password, first_name, last_name, user_type, email, creation_time, random_string, display_name, address, phone, approved, map_location) FROM stdin;
58	seller_4	64c9ac2bb5fe46c3ac32844bb97be6bc	میلاد	بشیری	seller	info@gmail.com	2011-12-12 14:58:42	\N	سینما	تهران، میدان رسالت	09121212121	f	35.73658336551923 51.48810430145261
59	seller_5	64c9ac2bb5fe46c3ac32844bb97be6bc	میلاد	بشیری	seller	info@gmail.com	2011-12-12 14:58:42	\N	رستوران	تهران، میدان رسالت	09121212121	f	35.73658336551923 51.48810430145261
57	seller_3	64c9ac2bb5fe46c3ac32844bb97be6bc	میلاد	بشیری	seller	info@gmail.com	2011-12-12 14:58:42	\N	سینما	تهران، میدان رسالت	09121212121	t	35.73658336551923 51.48810430145261
56	seller_2	64c9ac2bb5fe46c3ac32844bb97be6bc	میلاد	بشیری	seller	info@gmail.com	2011-12-12 14:58:42	\N	محصولات کامپیوتری	تهران، میدان رسالت	09121212121	t	35.73658336551923 51.48810430145261
55	seller_1	64c9ac2bb5fe46c3ac32844bb97be6bc	میلاد	بشیری	seller	info@gmail.com	2011-12-12 14:58:42	\N	فروشگاه موبایل	تهران، دانشگاه علم و صنعت	09121212121	t	35.74206966492453 51.50685830688474
\.


--
-- Data for Name: transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY transactions (id, user_id, product_id, count, transaction_time, buying_state, pursuit_code, delivered) FROM stdin;
168	60	54	1	2011-12-12 15:26:16+03:30	1	z8me3hahn0	t
169	61	54	1	2011-12-12 15:26:33+03:30	1	ld6y35szn1	t
170	62	54	1	2011-12-12 13:26:33+03:30	1	ld6y35szn1	t
171	68	54	1	2011-12-12 13:31:33+03:30	1	ld6y35szn1	t
172	73	54	1	2011-12-12 13:26:33+03:30	1	ld6y35szn1	t
173	75	54	1	2011-12-12 13:26:33+03:30	1	ld6y35szn1	t
175	60	55	1	2011-12-12 15:47:17+03:30	1	t12zf475d0	f
176	62	55	1	2011-12-12 15:47:42+03:30	1	mv0dgptu4z	f
174	39	55	1	2011-12-12 15:46:51+03:30	1	1yl46q2ags	t
177	61	55	1	2011-12-12 15:51:50+03:30	1	rlfdptnp5e	f
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, username, password, first_name, last_name, user_type, email, creation_time, random_string) FROM stdin;
39	admin	21232f297a57a5a743894a0e4a801fc3	مدیر	سایت	admin	admin@serahi.ir	2011-03-07 00:00:00	\N
\.


--
-- Name: customers_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY customers
    ADD CONSTRAINT customers_pk PRIMARY KEY (id);


--
-- Name: news_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY news
    ADD CONSTRAINT news_pk PRIMARY KEY (id);


--
-- Name: posts_rss_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY posts_rss
    ADD CONSTRAINT posts_rss_pkey PRIMARY KEY (id);


--
-- Name: products_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products
    ADD CONSTRAINT products_pk PRIMARY KEY (id);


--
-- Name: sellers_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sellers
    ADD CONSTRAINT sellers_pk PRIMARY KEY (id);


--
-- Name: transaction_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY transactions
    ADD CONSTRAINT transaction_pk PRIMARY KEY (id);


--
-- Name: username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT username_unique UNIQUE (username);


--
-- Name: users_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

