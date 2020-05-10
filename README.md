# php_csvRead
Simple class to work with data from csv files.
You can see the columns names, all rows or specific columns from a specific row.

How to:
The namespace is CsvRead;
Instantiate the class by entering the path with file name. If delimiter is different of ';' you must specify when instanciate the class:
 $file = '../uploads/file.csv';  
 $csvRead = new CsvRead($file, ',');  
 
If the file haven't columns title, use setHasColumnsName(false)  

To see columns names: getColumnsName()  
To see all rows: getRows()  
To see a specific row: getRow(2, ['someColumn', 'otherColumn']) when you inform the number of row and optionally one strign with column name or array with columns names  
To apply an function for each row you can use the processRow($function). $function is a lambda function that must receive a row as a parameter. You can use this to validade columns.
