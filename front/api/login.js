import axios from "axios";

async function authentication(data) {
  return await axios.post(process.env.VUE_APP_API_URL + "authentication", data);
}

export { authentication };
