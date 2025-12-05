import React from 'react';
import { SafeAreaView, StyleSheet, View, Text } from 'react-native';
import { StatusBar } from 'expo-status-bar';

const App: React.FC = () => {
  return (
    <View style={styles.container}>
      <StatusBar style="dark" />
      <SafeAreaView style={styles.safeArea}>
        <View style={styles.content}>
          <Text style={styles.title}>🎉 Kanun-i</Text>
          <Text style={styles.subtitle}>Mobil Uygulama Çalışıyor!</Text>
          <Text style={styles.description}>
            Expo başarıyla kuruldu. Şimdi uygulamayı geliştirmeye başlayabilirsiniz.
          </Text>
        </View>
      </SafeAreaView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#1D6583',
  },
  safeArea: {
    flex: 1,
  },
  content: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  title: {
    fontSize: 48,
    fontWeight: 'bold',
    color: '#FFFFFF',
    marginBottom: 10,
  },
  subtitle: {
    fontSize: 24,
    fontWeight: '600',
    color: '#F5A623',
    marginBottom: 20,
  },
  description: {
    fontSize: 16,
    color: '#FFFFFF',
    textAlign: 'center',
    opacity: 0.8,
  },
});

export default App;
