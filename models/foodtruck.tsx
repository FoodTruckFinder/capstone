export interface FoodTruck {
  _id: number;
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
    }
};
location: [number, number];
date_created: Date;
}
