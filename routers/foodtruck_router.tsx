import { Router } from "https://deno.land/x/oak/mod.ts";
import { getFoodTrucks, addFoodTruck, removeFoodTruck, updateFoodTruck, getFoodTrucksByName } from "../controllers/foodtruck_controller.tsx";
const router = new Router();
router
  .get("/foodtrucks", getFoodTrucks)
  .post("/foodtrucks", addFoodTruck)
  .delete("foodtruck/:name", removeFoodTruck)
  .put("/foodtruck/:name", updateFoodTruck)
  .get("/foodtrucks/:name", getFoodTrucksByName);

  export default router;