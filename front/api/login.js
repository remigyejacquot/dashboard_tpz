import axios from "axios";

async function authentication(data) {
  return await axios.post(
    "http://localhost:8888/dashboard/back/public/index.php/authentication",
    data
  );
}

export { authentication };
