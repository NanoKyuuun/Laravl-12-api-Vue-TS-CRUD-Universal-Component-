// src/api/resourceService.ts
import api from "./axios";

interface ResourceService<T> {
  getAll: () => Promise<T[]>;
  getById: (id: number) => Promise<T>;
  create: (data: any) => Promise<T>;
  update: (id: number, data: any) => Promise<T>;
  delete: (id: number) => Promise<any>;
}

export function createResourceService<T>(resource: string): ResourceService<T> {
  return {
    async getAll() {
      const res = await api.get(`/${resource}`);
      return res.data;
    },

    async getById(id: number) {
      const res = await api.get(`/${resource}/${id}`);
      return res.data;
    },

    async create(data: any) {
      const headers =
        data instanceof FormData
          ? { "Content-Type": "multipart/form-data" }
          : { "Content-Type": "application/json" };

      const res = await api.post(`/${resource}`, data, { headers });
      return res.data;
    },

    async update(id: number, data: any) {
      if (data instanceof FormData) {
        data.append("_method", "PUT");
        const res = await api.post(`/${resource}/${id}`, data, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        return res.data;
      } else {
        const res = await api.put(`/${resource}/${id}`, data);
        return res.data;
      }
    },

    async delete(id: number) {
      const res = await api.delete(`/${resource}/${id}`);
      return res.data;
    },
  };
}
