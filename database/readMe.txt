Documentation for the Database Whole Folder:

MySQL database named "shopping". The database includes the following tables:

users
orders
categories
types
colors
sizes
stickers
products


The following files are included in the folder:

index.php
createDatabase($mysqli): Creates a new database named "shopping".
dropDatabase($mysqli): Drops an existing database named "shopping".
selectDatabase($mysqli): Selects an existing database named "shopping".

usersDb.php
UsersTable(): CRUD for the users table.
ordersDb.php
OrdersTable(): CRUD for the orders table.
categoriesDb.php
CategoriesTable(): CRUD for the categories table.
typesDb.php
TypesTable(): CRUD for the types table.
colorsDb.php
ColorsTable(): CRUD for the colors table.
sizesDb.php
SizesTable(): CRUD for the sizes table.
stickersDb.php
StickersTable(): CRUD for the stickers table.
productsDb.php
ProductsTable(): CRUD for the products table.

index.php
allTables(): Creates all the tables in the database.
dropDatabase();