// src/api/postsService.ts
import { createResourceService } from "./resourceService";

export interface Makanan {
  id: number;
  name: string;
  description: string;
  img_makanan: string;
  price: number;
}

const makananService = createResourceService<Makanan>("makanan");

export default makananService;
