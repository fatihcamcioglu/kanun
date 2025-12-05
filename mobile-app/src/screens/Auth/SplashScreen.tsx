import React, {useEffect} from 'react';
import {View, Text, StyleSheet, ActivityIndicator} from 'react-native';
import {theme} from '@theme';

interface SplashScreenProps {
  navigation: any;
}

export const SplashScreen: React.FC<SplashScreenProps> = ({navigation}) => {
  useEffect(() => {
    // Check auth status and navigate
    const timer = setTimeout(() => {
      // TODO: Check if user is logged in
      navigation.replace('Login');
    }, 2000);

    return () => clearTimeout(timer);
  }, [navigation]);

  return (
    <View style={styles.container}>
      <Text style={styles.logo}>KANUN-Í</Text>
      <ActivityIndicator
        size="large"
        color={theme.colors.primary}
        style={styles.loader}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.background,
    alignItems: 'center',
    justifyContent: 'center',
  },
  logo: {
    ...theme.typography.logo,
    color: theme.colors.primary,
    marginBottom: theme.spacing.xl,
  },
  loader: {
    marginTop: theme.spacing.xl,
  },
});

