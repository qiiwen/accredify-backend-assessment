1. Create unit test cases and having folders for testing endpoints instead of putting everything in the PatientController.php
2. Storing the country code array mappings in the storage folder instead of processing the csv every time the mapping function is called
3. Refactor code to separate data preprocessing functions before passing into the functions in the controllers
4. Add more sophisticated error handling mechanisms eg logging, error messages to be shown
5. Create a frontend interface for endpoints
