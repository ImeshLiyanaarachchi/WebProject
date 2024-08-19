  //--------------------- javascript code for search and category listing------------------------------------//

  document.getElementById('searchInput').addEventListener('keyup', filterTable);
  document.getElementById('category').addEventListener('change', filterTable);

  function filterTable() {
  var input, filter, categorySelect, selectedCategory, table, tr, td, i, j, txtValue, categoryValue;

  input = document.getElementById('searchInput');
  filter = input.value.toLowerCase();
  
  categorySelect = document.getElementById('category');
  selectedCategory = categorySelect.value.toLowerCase();
  
  table = document.querySelector('.table-container table');
  tr = table.getElementsByTagName('tr');

  console.log("Selected Category:", selectedCategory); // Debugging statement

  for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
      tr[i].style.display = 'none'; // Hide the row initially
      
      td = tr[i].getElementsByTagName('td');
      if (td.length > 0) {
          categoryValue = td[4].textContent || td[4].innerText; // Assuming the category is in the 5th column
          console.log("Row Category:", categoryValue.toLowerCase()); // Debugging statement
          
          if (selectedCategory === "" || categoryValue.toLowerCase() === selectedCategory) {
              for (j = 0; j < td.length; j++) {
                  txtValue = td[j].textContent || td[j].innerText;
                  if (txtValue.toLowerCase().indexOf(filter) > -1) {
                      tr[i].style.display = ''; // Show the row if a match is found
                      break;
                  }
              }
          }
      }
  }
}
