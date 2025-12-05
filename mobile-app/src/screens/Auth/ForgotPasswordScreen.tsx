import React, {useState} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  SafeAreaView,
  TouchableOpacity,
} from 'react-native';
import {Header} from '@components/Header';
import {Input} from '@components/Input';
import {Button} from '@components/Button';
import {theme} from '@theme';

interface ForgotPasswordScreenProps {
  navigation: any;
}

export const ForgotPasswordScreen: React.FC<ForgotPasswordScreenProps> = ({
  navigation,
}) => {
  const [email, setEmail] = useState('');
  const [loading, setLoading] = useState(false);

  const handleSubmit = () => {
    setLoading(true);
    // TODO: Send OTP
    setTimeout(() => {
      setLoading(false);
      navigation.navigate('OTPVerification', {email});
    }, 1000);
  };

  return (
    <SafeAreaView style={styles.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.keyboardView}>
        <Header
          showLogo
          showBack
          onBackPress={() => navigation.goBack()}
          backgroundColor={theme.colors.background}
        />
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled">
          <View style={styles.content}>
            <Text style={styles.title}>Şifremi Unuttum</Text>
            <Text style={styles.subtitle}>
              Lütfen bir doğrulama kodu almak için e-posta adresinizi girin.
            </Text>
            <Input
              placeholder="E-posta veya telefon numarası"
              value={email}
              onChangeText={setEmail}
              keyboardType="email-address"
              autoCapitalize="none"
              autoCorrect={false}
            />
            <Button
              title="İleri"
              onPress={handleSubmit}
              loading={loading}
              fullWidth
              variant="primary"
            />
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.background,
  },
  keyboardView: {
    flex: 1,
  },
  scrollContent: {
    flexGrow: 1,
    padding: theme.spacing.lg,
  },
  content: {
    flex: 1,
    paddingTop: theme.spacing.xl,
  },
  title: {
    ...theme.typography.h1,
    marginBottom: theme.spacing.md,
  },
  subtitle: {
    ...theme.typography.subtitle,
    marginBottom: theme.spacing.xl,
  },
});

