// src/api/postsService.ts
import { createResourceService } from "./resourceService";

export interface Post {
  id: number;
  title: string;
  content: string;
  thumbnail: string;
}

const postService = createResourceService<Post>("posts");

export default postService;
