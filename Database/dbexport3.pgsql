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
    id uuid NOT NULL,
    username character varying(100),
    search character varying(100),
    type character varying(100),
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
4bf55d49-5a47-4281-962d-d4283bef462a	linen	lb	100
b53ead17-b57a-4b5a-b6c9-4d2c72a12e02	gold	oz	0.110000000000000001
cbdd3536-a28a-4e3b-9c32-51da972dd10f	copper	mt	6796
2ac07769-7d1c-4ecb-88b3-5ebd8498ce32	screen-printing ink	oz	0.0500000000000000028
e4d79a5b-bde0-4ce3-948d-0028bb0f8448	aluminum	ton	2248
97369ecd-af85-4add-96f2-34ceaa604043	elastic	kg	4.99000000000000021
5100f739-141d-4f5e-a48e-117909b84ea6	steel	mt	300
8e5116a9-2e47-42a2-b8ae-b41780529cea	cotton	lb	0.84760000000000002
578fd613-184c-41f9-b5c6-523d2c6c7da4	sugar	lb	0.100000000000000006
\.


--
-- Data for Name: composition; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.composition (id, product, commodity, unit_weight) FROM stdin;
8281da71-2e80-4dd1-a825-d46bd35ff647	tire	fillers	0
e588cda9-a0da-4333-90be-ac0bcc87080b	tire	textile reinforcement	0
516b94f1-198d-4c02-827e-3508b22f72db	tire	rubber	38.5300000000000011
5b9fe4a6-cd8e-4cc4-b561-fb596e5dbc35	hat	cotton	1
0a3862d3-275a-4cef-94bd-acce82975208	hat	leather	1
c5e4a032-88dc-4b66-8ef7-76cbfb187ab5	tire	steel	0.119999999999999996
8182368d-7b38-4b68-90a4-d3037961eaea	fan	steel	2
2ce8bcf7-12f5-41a1-94af-ed8bce292005	candy	sugar	3
aebc1943-4043-4175-b9f6-d57a4cad94c0	computer	gold	0.0100000000000000002
5cdc90f5-245a-471f-8aed-8d9871e6e968	something	aluminum	0.0100000000000000002
da81c191-905a-490a-811b-2287f995bac1	uniform	cotton	0.0100000000000000002
fa74b8a1-bfd4-4747-82ac-ff80f836faf1	uniform	elastic	0.0500000000000000028
e440ae9f-911e-46c1-a5f7-526b0ec6649e	lightbulb	glass	0
db40ac87-6c9e-4fcf-ab86-94c01b1ddc72	lightbulb	filament	0
0c4f5af1-bb73-4b3e-97b7-08803cde0cd2	lightbulb	copper	0.0299999999999999989
e2e81428-939d-4114-a53c-8f99a4633c84	lightbulb	iron ore	0.25
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
246ece4b-519c-4e07-9554-a9b5d2552066	toilet paper
94c66620-47bc-4eba-8b2f-7de9779b13aa	plastic bag
3765421e-1d29-44c1-bd90-d04e293668e9	chair
1e084ef1-e6fd-49b2-8aa9-b5f6543ff938	hat
5c708548-bca9-412c-b201-da21a0cd9d8c	fan
dc3cbc99-6c30-40bc-b74b-2f21564889c5	tire
8252628f-5184-4a85-9e8c-6b4dd2430e1a	lightbulb
8097d8d4-321d-47fe-9252-5a28d80d2844	candy
5e39206c-a1e8-4a70-87fb-7b64a4aea638	computer
07458b7d-9fc8-4846-80a8-9ed42d27f6e2	something
c7e60a1b-ac67-4c3f-9dd4-dba83a56141b	uniform
\.


--
-- Data for Name: search_history; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.search_history (id, username, search, type, search_time) FROM stdin;
93965af9-c18e-4846-ae6b-ca4ccf04a307	testusername	plastic bag	product	2018-04-30 16:32:51.678219
c91897dc-5778-4b0f-a0c7-cf27accce38d	testusername	lightbulb	product	2018-04-30 16:35:48.301933
ec04aa85-ae86-4a2c-978d-5790e60a7f5f	testusername	something	product	2018-04-30 16:36:49.834338
6ba26403-8c0d-4959-baab-3050f48f1c1a	testusername	toilet paper	product	2018-04-30 16:41:20.151383
839e692d-abbf-460c-8775-3743bf0c7a15	testusername	textile reinforcement	commodity	2018-04-30 16:58:35.062201
bec46e5e-486f-4fb7-8415-99e8f236dcac	testusername	tire	product	2018-04-30 17:12:37.961562
5fc9e2e1-7b3c-462e-bb52-9846153d8076	ozzy	copper	commodity	2018-04-30 17:13:01.563727
b0b3617a-b1fa-478b-8b1b-707e8e6a4dde	hamourit	cardboard	commodity	2018-04-30 17:28:34.179317
e761fda3-85a5-46e4-a092-8e0a741ed791	testusername	elastic	commodity	2018-04-30 18:05:21.517189
57b2546e-9ada-4969-b7a8-1978481adb54	testusername	tire	product	2018-04-30 16:33:20.996872
baf5455c-4dde-4d98-9e47-a20bbed419a8	testusername	hat	product	2018-04-30 16:35:57.79222
449c0ab7-29d4-4229-99cf-6a5cf5a086d9	testusername	computer	product	2018-04-30 16:39:33.980791
cb0518c2-def4-4a57-ba87-00a4fcbb6052	testusername	tire	product	2018-04-30 16:41:27.651605
0d4746a9-fc4c-4a34-8a50-d00c15ecfd7e	testusername	uniform	product	2018-04-30 17:03:03.383027
d8dc5218-8276-4638-aa49-6f856b0f61df	testusername	cotton	commodity	2018-04-30 17:12:50.831
c1b54301-eed6-4cc9-9c7a-58a1bdf3380f	hamourit	chair	product	2018-04-30 17:23:00.285003
85b46414-bb4a-46f8-9a92-0d90a1eecec1	ozzy	copper	commodity	2018-04-30 17:33:10.485957
3ed91cfe-02cb-4ec6-9c10-4133139e20dc	ozzy	copper	commodity	2018-04-30 18:12:07.383501
108620c1-ca07-4d78-bdc2-07a6a9be1fb6	hamourit	cardboard	commodity	2018-04-25 16:42:29.7553
fe003b0e-7e98-4579-87dc-f0cea90403eb	hamourit	cardboard	commodity	2018-04-25 16:42:56.606606
f35f76e4-b440-44b9-bbdb-8e18ec07de60	hamourit	cotton	commodity	2018-04-25 17:23:55.045256
447ea8c1-e260-4f39-90c1-9b15817f2733	hamourit	chair	product	2018-04-25 17:32:22.876842
7e20d8b2-4dbe-4294-a520-c0672452bbe8	hamourit	hard sawnwood	commodity	2018-04-25 17:32:38.589733
8b53a20d-bcab-4322-808a-2c79196d01e8	hamourit	fillers	commodity	2018-04-25 18:03:31.021269
66a94b33-41be-4dcd-86eb-f21477948e10	hamourit	leather	commodity	2018-04-25 18:03:48.013005
a355ea41-50bb-4476-a8f9-74f1ee51a454	hamourit	steel	commodity	2018-04-25 18:04:05.129987
a87da629-d2c1-485b-8a59-1b85a917a9f9	hamourit	cardboard	commodity	2018-04-25 19:08:04.015998
e3fe8219-d4f9-42bb-b327-2f479f218af4	hamourit	toilet paper	product	2018-04-25 19:09:43.74671
39302d59-6eae-4510-b7d9-3d87ed59482d	hamourit	bleach	commodity	2018-04-25 19:16:52.331601
aa413519-9d5d-4ac4-80fc-aa8bb4686e66	hamourit	hard sawnwood	commodity	2018-04-25 19:27:06.533408
3b37f4f9-3660-4175-81c8-38d43c769a44	hamourit	toilet paper	product	2018-04-25 19:30:56.275308
2afb8fcb-ee33-44ef-a915-500c36bb0c4f	hamourit	toilet paper	product	2018-04-25 20:20:40.098133
8cb19595-f99c-423b-9b1c-2fd4415f12f8	hamourit	chair	product	2018-04-25 20:30:58.69919
d5fe9c2a-4daf-48b3-b853-4fc57849720e	ozzy	toilet paper	product	2018-04-25 23:27:38.233241
77208342-c18d-43a8-ae86-824f4b82376c	ozzy	tire	product	2018-04-25 23:29:54.666789
6dfb7be8-a765-456e-bd0c-a2cabfa8d56f	ozzy	copper	commodity	2018-04-25 23:31:37.541055
fae48af2-8789-4f42-a3b7-e6e732b6e50a	ozzy	toilet paper	product	2018-04-25 23:32:29.536669
cce06213-9a3a-43c8-938c-aadbe53b4d82	ozzy	chair	product	2018-04-25 23:32:41.008909
83930e17-7fcb-47af-944f-7df8e62314bb	hamourit	cardboard	commodity	2018-04-25 23:40:27.260599
fd5c9b60-9d3c-492c-897d-1dd0ce2e63e1	ozzy	cardboard	commodity	2018-04-25 23:52:16.74162
ad4c8f27-086b-4088-8300-2af55444a8b2	ozzy	cardboard	commodity	2018-04-25 23:52:40.370067
ab83c5e5-323d-4580-82c5-35f2fc700c81	ozzy	cotton	commodity	2018-04-25 23:52:50.812798
91ca1e5f-6e5c-4f7b-a5ec-2d519087307f	ozzy	plastic bag	product	2018-04-25 23:53:09.422273
01408b70-5505-4684-960e-967403fb3fb1	ozzy	cardboard	commodity	2018-04-25 23:58:50.966388
61a88941-0fe9-490e-b7b5-19545019a609	ozzy	tire	product	2018-04-25 23:59:35.922752
6ce97f65-ccef-466b-ab64-04c651b8d097	ozzy	cotton	commodity	2018-04-26 00:04:48.435956
c82d9b40-b074-4581-a972-1cd9570c2c31	ozzy	cotton	commodity	2018-04-26 00:18:34.906582
c061e254-2d7b-4f45-91b0-3f7b35581226	ozzy	copper	commodity	2018-04-26 00:20:11.025737
05594f45-6878-4d00-bb15-04da3d30f393	ozzy	tire	product	2018-04-26 00:39:24.619769
90751c2a-8126-4edc-a1f0-f10a82d6db62	ozzy	tire	product	2018-04-26 00:42:03.044605
761bd244-4f7f-4b37-bdff-2d43a44ac4b0	ozzy	copper	commodity	2018-04-26 00:45:31.092246
bfb2c30e-8dc3-4580-a793-5f8d80b25bac	ozzy	cotton	commodity	2018-04-26 00:52:45.378152
bae90e35-3429-4043-a7e6-f5e416d1cd68	ozzy	tire	product	2018-04-26 01:02:11.812354
2f5e0dbb-4aba-4cb8-95f8-d4a08b3573ff	ozzy	chair	product	2018-04-26 01:02:35.93426
44cbfd97-2b47-46c9-b4f4-69898656a2a3	ozzy	copper	commodity	2018-04-26 01:02:49.402012
5a6b7626-60ec-40cc-b807-184ed86a3c03	ozzy	tire	product	2018-04-26 01:10:10.436392
bf7dd7d8-1257-439a-8241-1a1d034ee80c	ozzy	cotton	commodity	2018-04-26 01:12:09.536216
45ced4b0-e2a8-4a27-a372-49796341343f	ozzy	plastic bag	product	2018-04-26 01:19:24.196852
79062b06-df90-46ea-a3aa-b486b8177340	ozzy	copper	commodity	2018-04-26 01:22:23.502814
1fd0f30e-1bd2-4df3-b455-cdfb436daa18	ozzy	cotton	commodity	2018-04-26 01:26:41.999477
18bb60e6-cd04-41f5-aea5-c2dcb65d4330	ozzy	cotton	commodity	2018-04-26 02:01:00.686996
3b616500-4962-4c49-b6c6-ead1b20394f6	hamourit	toilet paper	product	2018-04-26 02:04:33.548161
4fda21a6-aba0-403c-93db-b7db60512e6e	ozzy	tire	product	2018-04-26 02:07:52.109844
f8becb9b-003f-4f74-beca-b03b843f1499	ozzy	copper	commodity	2018-04-26 02:15:33.106985
dc5d1926-ba03-4166-a2b6-309ddf1f10ae	ozzy	toilet paper	product	2018-04-26 04:10:50.888232
727a9983-741b-40d8-a6a5-f7ee905d0c95	ozzy	copper	commodity	2018-04-26 04:13:28.559957
6740b3d3-2a1f-4fad-8abe-0162038d34f4	ozzy	tire	product	2018-04-26 04:35:10.783699
e31b3d58-e1a9-44de-96a6-cb4b327f4078	ozzy	candy	product	2018-04-26 04:58:40.033143
51cd3cac-f7c0-4d09-8cde-b082f45689b9	ozzy	cotton	commodity	2018-04-26 04:59:47.737008
233d0857-3f48-4cc5-8c58-56b6b3898fb0	ozzy	cotton	commodity	2018-04-26 05:03:48.760044
72f36dfd-7f68-4a35-96af-fc9833cca088	ozzy	candy	product	2018-04-26 05:12:49.902528
f2908261-6787-4b6f-982d-2dbf7e2b360d	ozzy	copper	commodity	2018-04-26 05:13:39.392229
c94a0e2f-7041-4255-ab82-4207f1a6c33b	ozzy	candy	product	2018-04-26 05:23:44.874562
3a1516ed-1087-4bb7-990e-7ff2c565684f	ozzy	copper	commodity	2018-04-26 05:25:35.028644
157cb3f5-77d7-45c6-8a13-51c5f44ceba2	ozzy	cotton	commodity	2018-04-26 06:22:20.915602
08a4f073-a4e6-4a0f-b2d5-812493f72a56	ozzy	cotton	commodity	2018-04-26 08:15:20.205097
38bce57b-870e-449f-a30b-2663b9d7c760	testusername	tire	product	2018-04-26 14:18:19.504348
919e2941-6591-4edb-b824-f8364369e9a4	testusername	cotton	commodity	2018-04-26 14:18:58.047261
4f70a765-dc6f-407d-8872-2d445c7cfbdf	acabiera	tire	product	2018-04-26 16:39:31.55685
a67e0a48-9a3a-4c75-bba2-6b01dc6cbe47	ozzy	cotton	commodity	2018-04-26 16:41:23.242986
42e340d4-2d51-4cab-aaca-0d0afbfd10de	ozzy	cotton	commodity	2018-04-26 16:41:56.154169
df51f357-373e-4f96-a11c-cb9177f5983c	ozzy	cotton	commodity	2018-04-26 16:42:31.090129
28817543-32b2-4cd2-a9e7-1a754cd36173	hamourit	cotton	commodity	2018-04-26 17:36:36.846942
1382d56e-f5cb-41dc-afea-c9bfa7af90f8	acabiera	tire	product	2018-04-26 17:45:15.824383
bb175bfb-c847-43d5-93e9-5d1561a3e441	hamourit	chair	product	2018-04-26 18:08:21.128893
cce2021f-4a74-43af-a5e7-34924f168542	acabiera	tire	product	2018-04-26 18:09:53.647588
c52cafd1-02af-41bc-8e9a-df69903e4732	acabiera	cotton	commodity	2018-04-26 18:11:29.198236
6daf02ed-9ceb-45e9-8d65-9f1f1eb262d3	ozzy	tire	product	2018-04-26 18:17:22.882789
9e41b2c4-e18a-4e5b-9be4-9252f3083307	acabiera	toilet paper	product	2018-04-26 18:20:18.440229
ec6fada0-3894-49f5-ae3a-a614e06791f7	acabiera	cotton	commodity	2018-04-26 18:20:51.275831
ea4ce620-a6fb-4e67-91e9-8a3ab3da88b7	acabiera	tire	product	2018-04-26 18:22:47.773546
541b3fe2-f14e-4c03-81a3-95e117a4eeaa	ozzy	cotton	commodity	2018-04-26 18:24:04.718777
f557be01-8bcd-4100-b093-58518d5beede	hamourit	chair	product	2018-04-26 18:24:14.190289
b1d1f172-79b8-4573-bbbc-aa50d802945f	hamourit	candy	product	2018-04-26 18:25:26.811951
39c9ca5f-41eb-4105-9649-28651aaf2f88	ozzy	lightbulb	product	2018-04-26 18:25:57.295356
ea6ba0d7-c10c-44a0-a6c6-f470580cefce	ozzy	computer	product	2018-04-26 18:27:44.152459
53a369f2-65dc-46d0-a38c-6b5203356ce0	ozzy	tire	product	2018-04-26 18:28:41.182101
fff9f2b2-4330-47ac-a6c7-8c7aa7134795	acabiera	gold	commodity	2018-04-26 18:56:33.905675
ff6ac737-c96a-4a43-b1e9-19174ba61404	acabiera	cotton	commodity	2018-04-28 00:47:03.112697
d74b9cd5-563a-409f-ad7d-819d038a8f6e	acabiera	cotton	commodity	2018-04-28 00:52:13.917363
3e842321-4549-4685-bcfd-98b53979bb47	acabiera	tire	product	2018-04-28 00:54:39.835837
71bdc0d7-6ae5-4588-ad37-74e19145afb5	acabiera	tire	product	2018-04-28 23:36:47.06949
bc4a307f-6e5f-46a6-8739-bce21f48ca98	acabiera	tire	product	2018-04-29 04:21:18.043812
27d4a9a0-6602-4c26-9338-58ab25b98c81	acabiera	cotton	commodity	2018-04-29 04:28:14.97601
ed84e383-00cd-47e5-80e0-d10f82cfb475	hamourit	chair	product	2018-04-29 04:33:01.967469
1eab9fd4-120e-4d8a-a325-8d392ddd6b93	testusername	something	product	2018-04-30 13:01:27.799026
15ad0774-9ef1-4e90-ad9a-f1b920e28bc2	acabiera	tire	product	2018-04-30 14:14:16.479849
4d280480-d2c2-4a2d-9289-e547fa1040f6	testusername	aluminum	commodity	2018-04-30 15:12:19.510116
c29646fb-fc41-43c1-b34c-66170c1684f4	acabiera	tire	product	2018-04-30 16:08:04.711711
4052be4b-fffb-4f48-9f88-7c3a094ba7f8	acabiera	cotton	commodity	2018-04-30 16:08:41.456493
1b18bfd7-eaf0-4804-82e1-cb2f584192fc	ozzy	copper	commodity	2018-04-30 16:20:50.407216
8645a721-7228-47a6-9700-16fe6c3b6e96	testusername	plastic bag	product	2018-04-30 16:35:43.474469
bf9f3bb6-3851-40a8-b518-d170d1df684c	testusername	fan	product	2018-04-30 16:36:04.571134
83987314-bfdd-49d7-b896-41ebd9d80b54	testusername	chair	product	2018-04-30 16:40:14.043225
0fc03da9-b8be-423b-8964-12827c4391da	testusername	tire	product	2018-04-30 16:51:14.304328
d0167068-5660-4e92-94dc-5ed8b043c26b	testusername	elastic	commodity	2018-04-30 17:11:51.890211
aae35889-62ad-4950-a7c9-bcaceb7e503e	testusername	tire	product	2018-04-30 17:12:59.62446
88c36592-d7c9-4a2f-82c1-a374014a02e5	testusername	tire	product	2018-04-30 17:25:23.692853
bc5cf29e-6832-4090-831a-cfd51ac30a27	testusername	tire	product	2018-04-30 18:04:51.065502
d22470f3-3750-4e62-90cf-afa2872a4334	ozzy	cotton	commodity	2018-04-30 18:12:17.955177
\.


--
-- Data for Name: user_stuff; Type: TABLE DATA; Schema: public; Owner: scservice
--

COPY public.user_stuff (id, username, password, last_login) FROM stdin;
4bc1cfb7-d281-4a5f-9b6f-d98323c36b7a	acabiera	april1	2018-04-30 17:12:33.044743
73b0fdaf-171f-465a-af76-246c584a0699	hamourit	Burningblade0	2018-04-30 17:48:02.028744
f10ef4dc-537b-43df-9d13-5e3407094573	testusername	t3stp4ss	2018-04-30 18:01:42.262473
4baf3218-6bcc-4160-a55f-b19e934a07bc	ozzy	project123	2018-04-30 18:59:57.485789
2a9188a4-f0ce-4239-985f-7df9fe65110e	aauser	aapass	2018-04-22 20:49:47.788399
bae6ef88-4327-41b6-b5a1-1baaa269420c	thisname	thispass	2018-04-22 21:23:14.616277
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

