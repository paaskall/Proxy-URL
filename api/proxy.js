// api/proxy.js
export default async function handler(req, res) {
  const { url } = req.query;

  if (!url) {
    res.status(400).send("Error: Parameter 'url' tidak ada.");
    return;
  }

  try {
    const response = await fetch(url, {
      headers: {
        "User-Agent": "Node Proxy"
      }
    });

    if (!response.ok) {
      res.status(500).send(`Error: Gagal mengambil data dari ${url}`);
      return;
    }

    const data = await response.text();

    // Izinkan diakses dari frontend
    res.setHeader("Access-Control-Allow-Origin", "*");
    res.setHeader("Content-Type", "text/calendar; charset=UTF-8");

    res.status(200).send(data);
  } catch (error) {
    res.status(500).send("Error: " + error.message);
  }
}
