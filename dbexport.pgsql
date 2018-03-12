--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.12
-- Dumped by pg_dump version 9.5.12

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: materials; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.materials (
    id uuid NOT NULL,
    name character varying(80) NOT NULL,
    price double precision NOT NULL,
    unit character varying(10) NOT NULL
);


ALTER TABLE public.materials OWNER TO scservice;

--
-- Name: mlightbulb; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.mlightbulb (
    id uuid NOT NULL,
    name character varying(100) NOT NULL,
    unitprice double precision,
    unitweight double precision
);


ALTER TABLE public.mlightbulb OWNER TO scservice;

--
-- Name: mplasticbag; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.mplasticbag (
    id uuid NOT NULL,
    name character varying(100) NOT NULL,
    unitprice double precision,
    unitweight double precision
);


ALTER TABLE public.mplasticbag OWNER TO scservice;

--
-- Name: mtire; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.mtire (
    id uuid NOT NULL,
    name character varying(100) NOT NULL,
    unitprice double precision,
    unitweight double precision
);


ALTER TABLE public.mtire OWNER TO scservice;

--
-- Name: mtoiletpaper; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.mtoiletpaper (
    id uuid NOT NULL,
    name character varying(100) NOT NULL,
    unitprice double precision,
    unitweight double precision
);


ALTER TABLE public.mtoiletpaper OWNER TO scservice;

--
-- Name: products; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.products (
    id uuid NOT NULL,
    lookupcode character varying(32) NOT NULL,
    name character varying(100) NOT NULL,
    materialstable character varying(32) NOT NULL
);


ALTER TABLE public.products OWNER TO scservice;

--
-- Name: search_history; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.search_history (
    id uuid,
    username character varying(100),
    search character varying(100),
    last_login timestamp without time zone DEFAULT now()
);


ALTER TABLE public.search_history OWNER TO scservice;

--
-- Name: user_stuff; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.user_stuff (
    id uuid,
    username character varying(60),
    password character varying(25),
    last_login timestamp without time zone,
    savedcookie character varying(100)
);


ALTER TABLE public.user_stuff OWNER TO scservice;

--
-- Data for Name: materials; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.materials (id, name, price, unit) FROM stdin;
de96466e-4a61-4d2f-a7d9-934f311f88d9	productname	0	0
cf8ef12e-41d5-479e-8605-819de7711c99	Chicken	1.48380000000000001	lb
cbdd3536-a28a-4e3b-9c32-51da972dd10f	Copper	6828	mt
\.


--
-- Data for Name: mlightbulb; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.mlightbulb (id, name, unitprice, unitweight) FROM stdin;
927a83a1-9347-43e8-8be5-dd760c8a9d18	copper wire	\N	1.39999999999999991
ef530c43-0043-4b46-a9b3-70eec0537c2f	iron wire	\N	2.25
844c397b-9015-418e-8f2c-fe6828f0b59c	glass	\N	2.64000000000000012
7a05f776-d0e1-470f-8be4-7dc5acc0ea27	filament	\N	1.10000000000000009
\.


--
-- Data for Name: mplasticbag; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.mplasticbag (id, name, unitprice, unitweight) FROM stdin;
634710d3-7b69-42b7-80b5-2453ebac65cd	polyethylene	\N	3.45000000000000018
8917baed-e38c-481f-a6d4-49fe60399fd6	ink	\N	2.33000000000000007
\.


--
-- Data for Name: mtire; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.mtire (id, name, unitprice, unitweight) FROM stdin;
05ecebde-6985-4c75-a750-c1f74c1cf1ea	rubber	\N	2.54000000000000004
dded8dc1-4d42-43ba-9e3f-49e9c0fba388	fillers	\N	3.22999999999999998
36143e11-9d92-48a5-bbcd-62abda9f8126	metal reinforcement	\N	1.34000000000000008
76f49ef1-7c06-40fc-a147-ef1de585710a	textile reinforcement	\N	2.43999999999999995
\.


--
-- Data for Name: mtoiletpaper; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.mtoiletpaper (id, name, unitprice, unitweight) FROM stdin;
93637725-1aa5-4f41-b83e-77390b17ab7a	recycled paper	\N	3.95000000000000018
a42b3306-862a-402e-8ac7-eb7e2567094a	water	\N	4.41999999999999993
0456871c-7fee-4e3d-a5f3-4f1f1174370a	bleach	\N	5
f363013f-c6eb-4f45-8f6d-1ddb80333683	cardboard	\N	3.12000000000000011
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.products (id, lookupcode, name, materialstable) FROM stdin;
8252628f-5184-4a85-9e8c-6b4dd2430e1a	lookupcode1	Lightbulb	mLightbulb
63d1834a-d8da-4727-b969-d5537ebc34ec	lookupcode2	Tire	mTire
246ece4b-519c-4e07-9554-a9b5d2552066	lookupcode3	Toilet Paper	mToiletPaper
94c66620-47bc-4eba-8b2f-7de9779b13aa	lookupcode4	Plastic Bag	mPlasticBag
\.


--
-- Data for Name: search_history; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.search_history (id, username, search, last_login) FROM stdin;
\.


--
-- Data for Name: user_stuff; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.user_stuff (id, username, password, last_login, savedcookie) FROM stdin;
f10ef4dc-537b-43df-9d13-5e3407094573	testusername	t3stp4ss	2018-03-09 17:35:09.159561	\N
\.


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

