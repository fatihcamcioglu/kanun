import axios, {AxiosInstance, AxiosRequestConfig} from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

const API_BASE_URL = __DEV__
  ? 'http://localhost:8000/api' // Development
  : 'https://kanun.test/api'; // Production

class ApiService {
  private api: AxiosInstance;

  constructor() {
    this.api = axios.create({
      baseURL: API_BASE_URL,
      timeout: 10000,
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
    });

    this.setupInterceptors();
  }

  private setupInterceptors() {
    // Request interceptor - Add auth token
    this.api.interceptors.request.use(
      async config => {
        const token = await AsyncStorage.getItem('authToken');
        if (token) {
          config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
      },
      error => {
        return Promise.reject(error);
      },
    );

    // Response interceptor - Handle errors
    this.api.interceptors.response.use(
      response => response,
      async error => {
        if (error.response?.status === 401) {
          // Unauthorized - Clear token and redirect to login
          await AsyncStorage.removeItem('authToken');
          // TODO: Navigate to login
        }
        return Promise.reject(error);
      },
    );
  }

  // Auth endpoints
  async login(email: string, password: string) {
    const response = await this.api.post('/auth/login', {email, password});
    if (response.data.token) {
      await AsyncStorage.setItem('authToken', response.data.token);
    }
    return response.data;
  }

  async register(data: {
    name: string;
    email: string;
    phone: string;
    password: string;
  }) {
    const response = await this.api.post('/auth/register', data);
    if (response.data.token) {
      await AsyncStorage.setItem('authToken', response.data.token);
    }
    return response.data;
  }

  async logout() {
    await AsyncStorage.removeItem('authToken');
  }

  async forgotPassword(email: string) {
    return this.api.post('/auth/forgot-password', {email});
  }

  async verifyOTP(email: string, code: string) {
    return this.api.post('/auth/verify-otp', {email, code});
  }

  async resetPassword(email: string, otp: string, password: string) {
    return this.api.post('/auth/reset-password', {email, otp, password});
  }

  // Questions endpoints
  async getQuestions() {
    return this.api.get('/questions');
  }

  async getQuestion(id: number) {
    return this.api.get(`/questions/${id}`);
  }

  async createQuestion(data: {
    category_id: number;
    title: string;
    body: string;
    files?: any[];
  }) {
    const formData = new FormData();
    formData.append('category_id', data.category_id.toString());
    formData.append('title', data.title);
    formData.append('body', data.body);
    // TODO: Append files to formData
    return this.api.post('/questions', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  }

  // Videos endpoints
  async getVideos() {
    return this.api.get('/videos');
  }

  async getVideo(id: number) {
    return this.api.get(`/videos/${id}`);
  }

  // Categories endpoints
  async getCategories() {
    return this.api.get('/categories');
  }

  // Profile endpoints
  async getProfile() {
    return this.api.get('/profile');
  }

  async updateProfile(data: any) {
    return this.api.put('/profile', data);
  }

  // Generic request method
  async request<T = any>(config: AxiosRequestConfig): Promise<T> {
    const response = await this.api.request<T>(config);
    return response.data;
  }
}

export const apiService = new ApiService();
export default apiService;

