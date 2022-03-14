import Api from "@/api";

const AuthRepository = {
  authenticate(email: string, password: string) {
    const formData = new FormData();
    formData.set("email", email);
    formData.set("password", password);

    return Api.post("/login", formData);
  },
};

export default AuthRepository;
