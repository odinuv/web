CREATE TABLE account (
  id_account serial NOT NULL,
  login character varying(100) NOT NULL,
  password character varying(255) NOT NULL
);
ALTER TABLE account ADD CONSTRAINT account_login_key UNIQUE (login);
ALTER TABLE account ADD CONSTRAINT account_pkey PRIMARY KEY (id_account);