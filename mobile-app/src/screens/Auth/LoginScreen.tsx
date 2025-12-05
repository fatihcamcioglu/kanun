import React, {useState} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  TouchableOpacity,
  SafeAreaView,
} from 'react-native';
import {Header} from '@components/Header';
import {Input} from '@components/Input';
import {Button} from '@components/Button';
import {theme} from '@theme';

interface LoginScreenProps {
  navigation: any;
}

export const LoginScreen: React.FC<LoginScreenProps> = ({navigation}) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);

  const handleLogin = async () => {
    setLoading(true);
    // TODO: Implement login logic
    setTimeout(() => {
      setLoading(false);
      navigation.replace('Main');
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
          backgroundColor={theme.colors.primary}
        />
        <ScrollView
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled">
          <View style={styles.content}>
            <Text style={styles.title}>Giriş Yap</Text>
            <Text style={styles.subtitle}>
              Türk Hukukunu Dünya'ya Taşıyoruz!
            </Text>

            <View style={styles.form}>
              <Input
                placeholder="E-posta veya telefon numarası"
                value={email}
                onChangeText={setEmail}
                keyboardType="email-address"
                autoCapitalize="none"
                autoCorrect={false}
              />
              <Input
                placeholder="Şifre"
                value={password}
                onChangeText={setPassword}
                secureTextEntry
                showPasswordToggle
              />
              <TouchableOpacity
                style={styles.forgotPassword}
                onPress={() => navigation.navigate('ForgotPassword')}>
                <Text style={styles.forgotPasswordText}>Şifremi unuttum?</Text>
              </TouchableOpacity>
              <Button
                title="Giriş Yap"
                onPress={handleLogin}
                loading={loading}
                fullWidth
                variant="primary"
              />
            </View>
          </View>

          <View style={styles.footer}>
            <Text style={styles.footerText}>Bir hesabınız yok mu? </Text>
            <TouchableOpacity onPress={() => navigation.navigate('Register')}>
              <Text style={styles.footerLink}>Kayıt Ol</Text>
            </TouchableOpacity>
          </View>
          <TouchableOpacity
            style={styles.continueButton}
            onPress={() => navigation.replace('Main')}>
            <Text style={styles.continueText}>Üye Olmadan Devam Et</Text>
          </TouchableOpacity>
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
    paddingBottom: theme.spacing.xl,
  },
  content: {
    flex: 1,
    padding: theme.spacing.lg,
  },
  title: {
    ...theme.typography.h1,
    marginBottom: theme.spacing.sm,
  },
  subtitle: {
    ...theme.typography.subtitle,
    marginBottom: theme.spacing.xl,
  },
  form: {
    marginTop: theme.spacing.lg,
  },
  forgotPassword: {
    alignItems: 'flex-end',
    marginBottom: theme.spacing.lg,
  },
  forgotPasswordText: {
    ...theme.typography.link,
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: theme.spacing.lg,
    paddingVertical: theme.spacing.md,
    backgroundColor: theme.colors.primary,
  },
  footerText: {
    ...theme.typography.body,
    color: theme.colors.text.inverse,
  },
  footerLink: {
    ...theme.typography.body,
    color: theme.colors.text.inverse,
    fontWeight: '600',
  },
  continueButton: {
    paddingVertical: theme.spacing.md,
    alignItems: 'center',
  },
  continueText: {
    ...theme.typography.link,
    fontSize: 16,
  },
});

