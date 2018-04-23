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
-- Name: commodities; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.commodities (
    id uuid NOT NULL,
    name character varying(80) NOT NULL,
    unit character varying(10),
    price double precision
);


ALTER TABLE public.commodities OWNER TO scservice;

--
-- Name: composition; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.composition (
    id uuid NOT NULL,
    product character varying(50) NOT NULL,
    commodity character varying(50) NOT NULL,
    unit_weight double precision
);


ALTER TABLE public.composition OWNER TO scservice;

--
-- Name: products; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.products (
    id uuid NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.products OWNER TO scservice;

--
-- Name: search_history; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.search_history (
    id uuid,
    username character varying(100),
    search character varying(100),
    search_time timestamp without time zone DEFAULT now()
);


ALTER TABLE public.search_history OWNER TO scservice;

--
-- Name: user_stuff; Type: TABLE; Schema: public; Owner: scservice
--

CREATE TABLE public.user_stuff (
    id uuid,
    username character varying(60),
    password character varying(25),
    last_login timestamp without time zone
);


ALTER TABLE public.user_stuff OWNER TO scservice;

--
-- Data for Name: commodities; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.commodities (id, name, unit, price) FROM stdin;
42d2e110-8c3f-4cd7-b472-fb9861dc9fb2	wood pulp	\N	\N
b94ec905-ff55-4677-8a3a-858003904d2f	glass	\N	\N
d8bdb597-c105-4843-82c4-ebeecb7b94bd	filament	\N	\N
928b23af-c017-4d57-892b-6bdc14c9924f	fillers	\N	\N
d892bc81-4ea1-4d69-b30c-db6bc85ea0de	textile reinforcement	\N	\N
bad6c5ea-5d9d-4776-8142-496280a156ff	polyethylene	\N	\N
57e4e4cc-8136-4875-bd34-dbf3de2d2f93	ink	\N	\N
1e5859ff-b1ef-422a-9431-11f9c963d57a	water	\N	\N
9e6162ee-2f93-4e08-8543-55fa427f6ad9	bleach	\N	\N
3a9eea1d-f41f-4810-ad9e-8acb1fe1cd36	cardboard	\N	\N
1fecdc29-ecc0-4609-b487-7ffffd414e47	leather	grams	0
0446ae67-6950-444e-98f2-f03cfb1e4520	iron ore	mt	57.8599999999999994
1075f9f7-bbbd-4f34-8bd3-85a3f3060a46	hard sawnwood	mt	697.440000000000055
f898e652-c8a2-4e7f-acc4-44496713d08e	rubber	lb	0.797699999999999965
cbdd3536-a28a-4e3b-9c32-51da972dd10f	copper	mt	6938
5100f739-141d-4f5e-a48e-117909b84ea6	steel	mt	300
8e5116a9-2e47-42a2-b8ae-b41780529cea	cotton	lb	0.84760000000000002
578fd613-184c-41f9-b5c6-523d2c6c7da4	sugar	lb	0.100000000000000006
\.


--
-- Data for Name: composition; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.composition (id, product, commodity, unit_weight) FROM stdin;
a042efae-28bc-4260-bd0a-09dbfd3db70c	candy	sugar	2
5b9fe4a6-cd8e-4cc4-b561-fb596e5dbc35	hat	cotton	1
0a3862d3-275a-4cef-94bd-acce82975208	hat	leather	1
8182368d-7b38-4b68-90a4-d3037961eaea	fan	steel	2
e440ae9f-911e-46c1-a5f7-526b0ec6649e	lightbulb	glass	0
db40ac87-6c9e-4fcf-ab86-94c01b1ddc72	lightbulb	filament	0
0c4f5af1-bb73-4b3e-97b7-08803cde0cd2	lightbulb	copper	0.0299999999999999989
e2e81428-939d-4114-a53c-8f99a4633c84	lightbulb	iron ore	0.25
778734c3-6394-4746-a023-a133efe035b4	tire	fillers	0
4449db29-bd25-420a-8ca2-64f4eaf473f8	tire	textile reinforcement	0
7872edfc-056b-402f-804e-8fa8d5f5cca0	tire	rubber	38.5300000000000011
ad85292c-b3de-45af-b75d-232f78cccb88	tire	steel	0.100000000000000006
ad55dbde-cd8d-48fe-9b51-0410e3f9c697	toilet paper	wood pulp	0
b10d384c-0d05-4214-bdd3-c81f1a273692	toilet paper	water	0
352af1fd-1a90-4660-b5e3-8aab737be50c	toilet paper	bleach	0
063afe76-899b-48b5-8fd8-1eacdfde86e4	toilet paper	cardboard	0
1debbd1b-2af1-4569-b3af-98c0f73d497a	plastic bag	polyethylene	0
3ac3ddc6-548d-423f-82a2-4c852d4f406a	plastic bag	ink	0
300e8dd4-1764-4a31-9dc4-97f27a275324	chair	steel	0.200000000000000011
cdb353e0-4dbe-4603-8a86-673ad1de29de	chair	cotton	0.299999999999999989
096b73e5-1007-4238-99a1-2d116a1cbf3b	chair	hard sawnwood	0.400000000000000022
\.


--
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.products (id, name) FROM stdin;
63d1834a-d8da-4727-b969-d5537ebc34ec	tire
246ece4b-519c-4e07-9554-a9b5d2552066	toilet paper
94c66620-47bc-4eba-8b2f-7de9779b13aa	plastic bag
3765421e-1d29-44c1-bd90-d04e293668e9	chair
31067963-8194-4db5-9e0f-3f3d25cea4cf	candy
1e084ef1-e6fd-49b2-8aa9-b5f6543ff938	hat
5c708548-bca9-412c-b201-da21a0cd9d8c	fan
8252628f-5184-4a85-9e8c-6b4dd2430e1a	lightbulb
\.


--
-- Data for Name: search_history; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.search_history (id, username, search, search_time) FROM stdin;
63cb3490-ecc4-44b4-b0fc-0a85ffd2c603	testusername	Toilet_Paper	2018-04-10 23:49:59.099301
bdda5171-27fe-4c50-afe8-e5c049165be6	testusername	tire	2018-04-11 00:33:32.645031
9d361cfe-91ac-497a-b4d5-4fc06e98f799	testusername	chair	2018-04-11 00:41:17.33199
ef37e08f-0f08-48a7-83ba-5dc829608f49	testusername	toilet paper	2018-04-11 00:44:04.618504
b4ff7c07-ccbe-47dd-b148-67198aad5a1f	testusername	toilet paper	2018-04-11 00:48:41.69458
db177b6f-0e30-4622-8a42-13405ffcd5f3	testusername	toilet paper	2018-04-11 00:49:26.196701
661db2bf-d3b5-4b2b-a754-d0c1efa0111b	testusername	chair	2018-04-11 00:50:11.365109
f71c740d-1346-49d3-80ed-f9f29340f1f7	testusername	tire	2018-04-11 00:50:55.69446
d38050c5-fd21-4d48-80b5-e0fca44f3d17	testusername	chair	2018-04-11 00:58:10.528579
5d30d5ef-e8db-4938-94d2-55a9f63f0dc6	testusername	chair	2018-04-11 00:59:30.930468
8a51bb02-edfd-40f6-b956-819bd7685a05	testusername	toilet paper	2018-04-11 01:02:38.57052
f5c15947-0ade-4f58-9f6c-fd212614b0e7	testusername	chair	2018-04-11 01:02:50.233118
2cba2204-3821-4d25-8789-c15ebb01d444	testusername	lightbulb	2018-04-11 01:03:04.047132
b0721393-af0a-4e9d-bddb-5f36ad22a6e1	testusername	chair	2018-04-11 01:14:52.275822
dcc723bb-e2a1-4ec7-bf50-d3f7d036aa4c	testusername	toilet paper	2018-04-11 01:15:00.290708
1498aeb6-d3ab-4599-b0e5-e677069fe12a	testusername	chair	2018-04-11 01:21:55.087508
458f7e4f-09c4-4e2b-95c6-2aabdf71c5ef	testusername	chair	2018-04-11 01:56:57.082105
f0c2bde9-35e5-4326-afbc-90c61d431bbd	testusername	tire	2018-04-11 02:50:10.027661
2482899d-9173-4e55-bfe9-86f200309f7e	testusername	tire	2018-04-11 04:37:54.062085
66f0fb58-b823-4b9c-a0e2-d95bc3676441	testusername	toilet paper	2018-04-11 04:51:17.637977
86bd8141-984e-4615-9d56-dc306124097d	testusername	tire	2018-04-11 04:52:58.567591
86b10e2e-4a48-46d1-bbf5-c1c2ae7cb298	testusername	tire	2018-04-11 04:53:07.783764
7c0e7ecf-15b1-43c9-8313-556a87710503	testusername	chair	2018-04-11 04:53:35.439679
c298ed1e-3998-4a54-bf11-117e3be79008	testusername	candy	2018-04-11 04:54:41.251293
d9a57b31-d0c1-40da-8bc3-9b037723fc0c	testusername	tire	2018-04-11 04:56:19.507344
6b8ff60c-194a-4970-a331-28cc3d0c6937	testusername	tire	2018-04-11 05:19:16.396034
321844fe-a006-4993-b6fa-98ef223f42af	testusername	chair	2018-04-11 08:46:43.112297
a3190eee-bf73-43b4-9c3e-9b4cf3b18f46	testusername	chair	2018-04-11 15:47:49.576291
5d4d87b9-555d-4905-9fbf-b5290f13639b	testusername	chair	2018-04-11 15:48:04.219958
bd37039d-375c-402f-9423-b65747eee0a7	testusername	chair	2018-04-11 15:48:16.253236
1e6f8975-cdef-4c61-a973-3def683a0af6	testusername	hat	2018-04-11 15:49:37.898942
da10f923-1f60-4244-9017-51ac01acedc3	testusername	tire	2018-04-11 15:53:31.17335
b59625d8-d765-412e-99ba-df18ccbfce92	testusername	lightbulb	2018-04-11 15:54:18.327183
0d4548c4-c102-4d1a-b505-1d580f751b76	testusername	lightbulb	2018-04-11 15:57:38.362632
8428a6d7-97b6-4143-976c-f8679d2c1808	testusername	lightbulb	2018-04-11 16:00:06.49663
73eb21de-ac3c-4827-99ad-4da611aa577f	testusername	tire	2018-04-11 16:01:29.69135
03e9697b-373b-4248-8172-f66600fcdc8c	testusername	hat	2018-04-11 16:06:54.593909
c786fd73-025e-4e6d-9736-4e18a451790e	testusername	toilet paper	2018-04-11 16:11:10.185205
6ab4be6b-4408-4381-9591-f4b3afd37fd5	testusername	chair	2018-04-11 16:12:50.040442
4cd34ce0-721b-481a-a6d0-1232ae5407b2	testusername	hat	2018-04-11 16:24:07.654995
6dbdbb8b-201e-4188-97f6-82a5d189ae7b	testusername	toilet paper	2018-04-11 16:51:05.211447
2b6fdb7e-2439-42e8-9e29-164d633ac991	testusername	plastic bag	2018-04-11 18:11:03.622626
49ff6fd4-b419-4862-a75c-a534d4b4784b	testusername	hat	2018-04-11 18:11:22.230447
368fa31f-8dc2-40a7-bcc6-975b614935bb	testusername	candy	2018-04-11 18:11:45.84695
d6f1bc3b-9c6b-46f7-af8c-aa6438699202	testusername	chair	2018-04-11 18:20:33.684077
a4e602b4-c24c-470b-811f-f7feeaf18f4f	testusername	plastic bag	2018-04-11 18:26:47.076418
02d9734f-3c09-45fa-a978-316ef28e198c	testusername	tire	2018-04-11 18:26:58.905102
2dcee35a-75e2-4efa-8423-a3dd72769d93	testusername	tire	2018-04-12 05:59:44.814996
d49be0df-eb50-40d6-b886-d8cf63ca7fe1	testusername	toilet paper	2018-04-12 06:27:25.621529
4c116659-a48d-48bf-a86f-35939599ab76	testusername	toilet paper	2018-04-12 06:33:28.43631
263e461f-3e15-4897-84f3-bb1d1c0d7732	testusername	tire	2018-04-12 06:33:35.296635
10f31304-f967-4780-b95b-7fde5349c01a	testusername	tire	2018-04-12 06:38:34.759786
700e4b02-9ba8-46b2-8b07-615350e2d1cb	testusername	toilet paper	2018-04-12 06:38:44.85665
5cec8623-813c-4c2c-be7e-618c62dd1098	testusername	tire	2018-04-12 06:39:41.407542
e4d150c1-7e7a-445b-a117-a3cd014827b2	testusername	toilet paper	2018-04-12 06:39:47.305763
dd7644b7-3321-44af-ad67-8c81b2068dd5	testusername	tire	2018-04-12 06:43:41.018382
1ed8ed52-d1c0-4b70-b8f7-149f88b211f9	testusername	toilet paper	2018-04-12 06:43:48.457162
a26561d8-9020-4571-b9ea-c333a19bc821	testusername	tire	2018-04-12 06:43:59.608775
ec00c8f3-4fec-4c0a-b62e-6a4774c494d9	testusername	candy	2018-04-12 06:54:34.002436
fbaada4f-0bd5-4968-babd-ce5115d95d0a	testusername	tire	2018-04-12 06:54:40.607772
c84e0c5c-8adf-4078-9deb-9234461173d3	testusername	toilet paper	2018-04-12 06:54:52.881291
af590d48-3325-40ac-b056-71191bd9eb0d	testusername	chair	2018-04-12 06:55:01.218464
015c3e8a-9cbe-4d4f-b622-8a19d3441a13	testusername	toilet paper	2018-04-12 06:56:52.486623
11605a4e-57f1-4ad1-a128-233c9c650d44	testusername	toilet paper	2018-04-12 06:58:04.961782
d3b06308-674e-458a-a3a4-27a1254761e9	testusername	toilet paper	2018-04-12 07:00:42.294243
9636fa96-c14d-48d2-9868-251dc2e20fbd	testusername	candy	2018-04-12 07:09:53.764928
905b8c3f-ae51-4f99-8650-73c3bb93798f	testusername	tire	2018-04-12 14:11:51.413916
05a9f357-8e15-49da-bee2-e451a456413f	testusername	tire	2018-04-12 14:15:24.107444
b225396a-23f8-48cb-82fa-037da8a12e8e	testusername	tire	2018-04-12 15:06:18.687414
8eafab16-8c42-44cd-9354-15b3989395e0	testusername	tire	2018-04-18 14:59:18.676689
5589b3f7-d801-478a-9dad-1e98d6c6f0ba	testusername	candy	2018-04-18 14:59:47.702105
178c416a-9e8a-40ae-b4ac-5a082128a8d3	testusername	tire	2018-04-19 14:28:42.347984
e9c62448-7088-4fe2-b6ff-4e38cefc6abd	testusername	tire	2018-04-19 14:39:39.923633
465bd6c8-d9de-405d-8b8f-c489947e7cfc	testusername	tire	2018-04-19 15:05:34.240587
358e9371-838a-4e62-b364-6653a18560bc	testusername	tire	2018-04-19 15:31:01.26528
0c7881ab-8e23-4aa9-b9dc-33c83eecda4a	testusername	tire	2018-04-19 15:57:40.249216
27d8e4f3-f0e3-49ab-8bb9-ffc0fd2c6d4d	testusername	tire	2018-04-19 16:11:52.641237
42bac883-30fc-4c0d-b685-3fcbc9c316af	testusername	tire	2018-04-22 17:54:01.04081
0a76eeec-ec09-43d8-9b66-d0b4ca2c628c	testusername	plastic bag	2018-04-22 17:54:16.769948
9ded1991-f787-4fdb-9f8a-fbc1c1dbbd2f	thisname	tire	2018-04-22 21:23:29.895194
61605a31-716a-4aa8-8f31-2cc73cc62d36	testusername	tire	2018-04-23 09:13:09.909289
3f107a9f-05a9-4aed-bab4-54d2bb907304	testusername	tire	2018-04-23 11:02:11.917051
b98a9481-8183-4317-a04d-31d9e5add112	testusername	tire	2018-04-23 13:02:01.38796
6defde8f-8485-4fd1-990a-390194eedf59	testusername	tire	2018-04-23 15:00:08.209541
5d2ef894-47a3-4f56-b6b4-73558e43a2a5	testusername	tire	2018-04-23 15:01:27.326946
64e27fb5-88fe-4866-b9e6-5183f895f872	testusername	tire	2018-04-23 15:03:00.70945
79457b14-fdb0-4664-bab8-d4467e35adcd	testusername	tire	2018-04-23 15:03:41.689203
30889f06-ed5d-42eb-b710-e6b58e1f5105	testusername	tire	2018-04-23 15:07:00.735161
0491b67e-3b84-421a-a5ad-021571fc4e03	testusername	tire	2018-04-23 15:33:16.244707
e16341b1-ced9-4e9c-89eb-b4d5bfaf9239	acabiera	tire	2018-04-23 15:54:07.449157
\.


--
-- Data for Name: user_stuff; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.user_stuff (id, username, password, last_login) FROM stdin;
4baf3218-6bcc-4160-a55f-b19e934a07bc	ozzy	project123	2018-04-23 16:31:46.100341
4bc1cfb7-d281-4a5f-9b6f-d98323c36b7a	acabiera	april1	2018-04-23 16:45:58.968538
73b0fdaf-171f-465a-af76-246c584a0699	hamourit	Burningblade0	2018-04-23 17:01:48.30545
\N	auser	apass	2018-04-22 20:41:33.474747
2a9188a4-f0ce-4239-985f-7df9fe65110e	aauser	aapass	2018-04-22 20:49:47.788399
bae6ef88-4327-41b6-b5a1-1baaa269420c	thisname	thispass	2018-04-22 21:23:14.616277
f10ef4dc-537b-43df-9d13-5e3407094573	testusername	t3stp4ss	2018-04-23 15:33:06.813291
\.


--
-- Name: commodities_pkey; Type: CONSTRAINT; Schema: public; Owner: scservice
--

ALTER TABLE ONLY public.commodities
    ADD CONSTRAINT commodities_pkey PRIMARY KEY (name);


--
-- Name: products_pkey; Type: CONSTRAINT; Schema: public; Owner: scservice
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (name);


--
-- Name: composition_commodity_fkey; Type: FK CONSTRAINT; Schema: public; Owner: scservice
--

ALTER TABLE ONLY public.composition
    ADD CONSTRAINT composition_commodity_fkey FOREIGN KEY (commodity) REFERENCES public.commodities(name) ON UPDATE CASCADE;


--
-- Name: composition_product_fkey; Type: FK CONSTRAINT; Schema: public; Owner: scservice
--

ALTER TABLE ONLY public.composition
    ADD CONSTRAINT composition_product_fkey FOREIGN KEY (product) REFERENCES public.products(name) ON UPDATE CASCADE;


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

