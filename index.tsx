import { Application  } from "https://deno.land/x/oak/mod.ts";
import router from "./routers/foodtruck_router.tsx"
import { config } from "https://deno.land/x/dotenv/mod.ts";
const env = config();
const PORT = env.PORT || 4000;
const HOST = env.HOST || "127.0.0.1";

const app = new Application();
app.use(router.routes());
app.use(router.allowedMethods());

console.log(`Listening on port ${PORT}...`);

await app.listen(`${HOST}:${PORT}`);
