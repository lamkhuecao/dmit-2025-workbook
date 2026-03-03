SELECT city_name, province FROM cities WHERE 1;
-- gives us just city name and province

SELECT city_name, province FROM cities LIMIT 5;
-- only 5 records returned

SELECT city_name FROM cities WHERE province = "ab";
-- only cities from Alberta

SELECT city_name, province, population FROM cities ORDER BY population DESC;
-- from biggest to smallest city

SELECT city_name, population FROM cities WHERE province = "on" AND population > 1000000;
-- all cities of at least 1 million people in ontario

SELECT * FROM cities WHERE is_capital = 1;
-- all capitals cities

SELECT * FROM cities WHERE city_name LIKE '%john%';
-- all cities that contains "john"

SELECT * FROM `cities` where province = "ns" or province = "nb" or province = "nl" or province = "pe"
-- all maritime provinces

-- 1. Find the smallest city
SELECT city_name, population FROM cities ORDER BY population LIMIT 1;

-- 2. Find all cities with a population between 10,000 and 40,000
SELECT city_name, population FROM cities WHERE population BETWEEN 10000 AND 40000;

-- Find all ontario cities from largest to smallest, but only return the records from 3 - 5