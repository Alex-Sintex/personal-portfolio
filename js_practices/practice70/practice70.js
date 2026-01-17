async function createPost(title, content) {
  try {
    let response = await fetch("https://jsonplaceholder.typicode.com/posts", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        title: title,
        body: content,
        userId: 1,
      }),
    });
    if (!response.ok) {
      throw new Error("Request error: " + response.statusText);
    }
    let data = await response.json();
    console.log("Record inserted: ", data);
  } catch (error) {
    console.error("Something went wrong creating the record: ", error);
  }
}

createPost("My title of example", "My content of example");
