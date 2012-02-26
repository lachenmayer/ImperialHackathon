/*

	Get into the PSQL shell and run '\i <path to this file>'
	This will clear the items, shops and purchases tables
	Then add in the data in the CSV files

	FILENAME: resetdb.sql
	AUTHOR:   Peregrine Park
	DATE:     26.02.2012
	PROJECT:  Imperial College Hackathon 2012

*/

DELETE FROM items;
DELETE FROM shops;
DELETE FROM purchases;

COPY items FROM '/Users/shared/items.csv' DELIMITERS ',' CSV;
COPY shops FROM '/Users/shared/shops.csv' DELIMITERS ',' CSV;
COPY purchases FROM '/Users/shared/purchases.csv' DELIMITERS ',' CSV;
