import React from 'react';
import {View, Text, StyleSheet, SafeAreaView} from 'react-native';
import ConfettiCannon from 'react-native-confetti-cannon';
import {Button} from '@components/Button';
import {theme} from '@theme';

interface PasswordResetSuccessScreenProps {
  navigation: any;
}

export const PasswordResetSuccessScreen: React.FC<PasswordResetSuccessScreenProps> = ({
  navigation,
}) => {
  return (
    <SafeAreaView style={styles.container}>
      <ConfettiCannon
        count={200}
        origin={{x: -10, y: 0}}
        fadeOut
        autoStart
      />
      <View style={styles.content}>
        <Text style={styles.title}>Şifren Yenilendi!</Text>
        <Text style={styles.subtitle}>
          Şifreniz başarıyla değiştirildi. Şimdi giriş yaparak kaldığınız yerden devam edebilirsiniz.
        </Text>
        <Button
          title="Giriş Yap"
          onPress={() => navigation.replace('Login')}
          fullWidth
          variant="primary"
          size="large"
        />
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.background,
  },
  content: {
    flex: 1,
    padding: theme.spacing.xl,
    justifyContent: 'center',
    alignItems: 'center',
  },
  title: {
    ...theme.typography.h1,
    color: theme.colors.primary,
    marginBottom: theme.spacing.lg,
    textAlign: 'center',
  },
  subtitle: {
    ...theme.typography.body,
    color: theme.colors.text.secondary,
    textAlign: 'center',
    marginBottom: theme.spacing.xxl,
    lineHeight: 24,
  },
});

