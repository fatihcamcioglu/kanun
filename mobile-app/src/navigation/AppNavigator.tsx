import React, {useState, useEffect} from 'react';
import {NavigationContainer} from '@react-navigation/native';
import {createStackNavigator} from '@react-navigation/stack';
import {AuthStack} from './AuthStack';
import {MainTab} from './MainTab';
// import AsyncStorage from '@react-native-async-storage/async-storage';

export type RootStackParamList = {
  Auth: undefined;
  Main: undefined;
};

const Stack = createStackNavigator<RootStackParamList>();

export const AppNavigator: React.FC = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // Check authentication status
    // TODO: Implement auth check
    checkAuth();
  }, []);

  const checkAuth = async () => {
    // const token = await AsyncStorage.getItem('authToken');
    // setIsAuthenticated(!!token);
    setIsLoading(false);
  };

  if (isLoading) {
    return null; // Or a loading screen
  }

  return (
    <NavigationContainer>
      <Stack.Navigator
        screenOptions={{
          headerShown: false,
        }}>
        {isAuthenticated ? (
          <Stack.Screen name="Main" component={MainTab} />
        ) : (
          <Stack.Screen name="Auth" component={AuthStack} />
        )}
      </Stack.Navigator>
    </NavigationContainer>
  );
};

