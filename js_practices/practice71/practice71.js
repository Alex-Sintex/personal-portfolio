// PUT method
/*
fetch("https://jsonplaceholder.typicode.com/posts/5", {
  method: "PUT",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify({
    title: "New title",
    body: "New description",
  }),
})
  .then((response) => response.json())
  .then((data) => console.log(data))
  .catch((error) => console.error(error));
*/

// DELETE method
/*
fetch("https://jsonplaceholder.typicode.com/posts/5", {
  method: "DELETE",
})
  .then((response) => response.json())
  .then((data) => console.log(data))
  .catch((error) => console.error(error));
*/

// PATCH method
fetch("https://jsonplaceholder.typicode.com/posts/5", {
  method: "PATCH",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify({
    title: "New title",
  }),
})
  .then((response) => response.json())
  .then((data) => console.log(data))
  .catch((error) => console.error(error));
