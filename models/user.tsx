export interface User {
    _id?: number;
    name: string;
    email: string;
    password: string;
    isOwner: boolean;
    foodtruckName?: string;
  }
  