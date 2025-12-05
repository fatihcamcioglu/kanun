import React, {useState} from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  SafeAreaView,
} from 'react-native';
import {Header} from '@components/Header';
import {Input} from '@components/Input';
import {Button} from '@components/Button';
import {theme} from '@theme';

interface NewPasswordScreenProps {
  navigation: any;
  route: any;
}

export const NewPasswordScreen: React.FC<NewPasswordScreenProps> = ({
  navigation,
  route,
}) => {
  const {email} = route.params;
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [loading, setLoading] = useState(false);

  const handleReset = () => {
    setLoading(true);
    // TODO: Reset password
    setTimeout(() => {
      setLoading(false);
      navigation.replace('PasswordResetSuccess');
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
              Sistemde kayıtlı olmasını istediğin yeni şifreni gir ve doğrula.
            </Text>
            <Input
              placeholder="Şifre"
              value={password}
              onChangeText={setPassword}
              secureTextEntry
              showPasswordToggle
            />
            <Input
              placeholder="Şifre Doğrulama"
              value={confirmPassword}
              onChangeText={setConfirmPassword}
              secureTextEntry
              showPasswordToggle
            />
            <Button
              title="Şifremi Yenile"
              onPress={handleReset}
              loading={loading}
              fullWidth
              variant="primary"
              disabled={!password || !confirmPassword || password !== confirmPassword}
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

