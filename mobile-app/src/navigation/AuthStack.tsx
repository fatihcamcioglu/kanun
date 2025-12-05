import React from 'react';
import {createStackNavigator} from '@react-navigation/stack';
import {
  SplashScreen,
  LoginScreen,
  RegisterScreen,
  ForgotPasswordScreen,
  OTPVerificationScreen,
  NewPasswordScreen,
  PasswordResetSuccessScreen,
} from '@screens/Auth';

export type AuthStackParamList = {
  Splash: undefined;
  Login: undefined;
  Register: undefined;
  ForgotPassword: undefined;
  OTPVerification: {email: string};
  NewPassword: {email: string; otp: string};
  PasswordResetSuccess: undefined;
};

const Stack = createStackNavigator<AuthStackParamList>();

export const AuthStack: React.FC = () => {
  return (
    <Stack.Navigator
      screenOptions={{
        headerShown: false,
        animationEnabled: true,
      }}
      initialRouteName="Splash">
      <Stack.Screen name="Splash" component={SplashScreen} />
      <Stack.Screen name="Login" component={LoginScreen} />
      <Stack.Screen name="Register" component={RegisterScreen} />
      <Stack.Screen name="ForgotPassword" component={ForgotPasswordScreen} />
      <Stack.Screen name="OTPVerification" component={OTPVerificationScreen} />
      <Stack.Screen name="NewPassword" component={NewPasswordScreen} />
      <Stack.Screen
        name="PasswordResetSuccess"
        component={PasswordResetSuccessScreen}
      />
    </Stack.Navigator>
  );
};

