import { FoodTruck } from "../models/foodtruck.tsx";

let foodtrucks: Array<FoodTruck> = [];

export const getFoodTrucks = ({ response }: { response: any }) => {
  response.body = foodtrucks;
};

export const getFoodTrucksByName = ({
  params,
  response,
}: {
  params: {
    name: string;
  };
  response: any;
}) => {
  const foodtruck = foodtrucks.filter(
    (foodtruck) => foodtruck.name === params.name
  );
  if (foodtrucks.length) {
    response.status = 200;
    response.body = foodtruck;
    return;
  }
  response.status = 400;
  response.body = { msg: `Cannot find Foodtruck: ${params.name}` };
};

export const addFoodTruck = async ({
  request,
  response,
}: {
  request: any;
  response: any;
}) => {
  const body = await request.body();
  const {
    id,
    userId,
    name,
    contact,
    location,
    date_created,
  }: {
    id: number;
    userId: number;
    name: string;
    contact: {
      phone: string;
      email: string;
      social_media: {
        twitter: string;
        facebook: string;
        yelp: string;
        other: string;
      };
    };
    location: [number, number];
    date_created: Date;
  } = body.value;

  const obj = {
    id: id,
    userId: userId,
    name: name,
    contact: {
      phone: contact.phone,
      email: contact.email,
      social_media: {
        twitter: contact.social_media.twitter,
        facebook: contact.social_media.facebook,
        yelp: contact.social_media.yelp,
        other: contact.social_media.other,
      },
    },
    location: location,
    date_created: date_created,
  };
  foodtrucks.push(obj);
  response.body = { msg: "OK", foodtruck: obj };
  response.status = 200;
};

export const updateFoodTruck = async ({
  params,
  request,
  response,
}: {
  params: {
    name: string;
  };
  request: any;
  response: any;
}) => {
  const temp = foodtrucks.filter((foodtruck) => foodtruck.name === params.name);
  const body = await request.body();
  const { foodtruck }: { foodtruck: string } = body.value;

  if (temp.length) {
    console.log(temp);
    // temp[0].name = name;
    response.status = 200;
    response.body = { msg: "OK" };
    return;
  }

  response.status = 400;
  response.body = { msg: `Cannot find foodtruck ${params.name}` };
};

export const removeFoodTruck = ({
  params,
  response,
}: {
  params: {
    name: string;
  };
  response: any;
}) => {
  const lengthBefore = foodtrucks.length;
  foodtrucks = foodtrucks.filter((foodtruck) => foodtruck.name !== params.name);

  if (foodtrucks.length === lengthBefore) {
    response.status = 400;
    response.body = { msg: `Cannot find foodtruck ${params.name}` };
    return;
  }

  response.body = { msg: "OK" };
  response.status = 200;
};
