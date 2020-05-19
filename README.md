# csvRead
Simple PHP class to work with data from csv files.  
You can see the columns names, all rows or specific columns from a specific row.

How to:  
The namespace is CsvRead;  
Instantiate the class by entering the path with file name.
 $file = '../uploads/file.csv';  
 $csvRead = new CsvRead($file);  
 
If the file haven't columns title, use setHasColumnsName(false)  
If delimiter is different to ';', use setDelimiter('yourDelimiter')  

Call the processFile() method to create data from file

To see columns names: getColumnsName()  
To see all rows: getRows()  
To see a specific row: getRow(2, ['someColumn', 'otherColumn']) where you inform the number of row and optionally one strign with column name or array with columns indexes (name or position)
To apply an function for each row you can use the processRow($function). $function is a lambda function that need receive a row as a parameter. You can use this to validade columns.

So we have:  
 $file = '../uploads/file.csv';   
 $csvRead = new CsvRead($file);
 $csvRead->setDelimiter(',') // Change the delimiter. Dafault is ';'  
    ->setSkipEmptyRows(false) // Maintaing empty rows. Default is true - Empty rows will return with empty array  
    ->processFile(); // Read the file  
 $columns = $csvRead->getColumnsName(); // Array with columns name  
 $allRrows = $csvRead->getRows(); // Array with all rows indexed by columns name  
 $row = $csvRead->getRow(8, ['id', 'name']); // Array with id and name from 8 line  
 $function = function($row){...};
 $csvRead->processRows($function); // Apply one function for each row
 
